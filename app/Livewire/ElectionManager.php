<?php

namespace App\Livewire;

use CondorcetPHP\Condorcet\Algo\Methods\Borda\BordaCount;
use CondorcetPHP\Condorcet\Algo\Methods\HighestAverages\SainteLague;
use CondorcetPHP\Condorcet\Algo\Methods\LargestRemainder\LargestRemainder;
use CondorcetPHP\Condorcet\Algo\Methods\Smith\SchwartzSet;
use CondorcetPHP\Condorcet\Algo\Methods\Smith\SmithSet;
use CondorcetPHP\Condorcet\Algo\Methods\STV\CPO_STV;
use CondorcetPHP\Condorcet\Algo\Methods\STV\SingleTransferableVote;
use CondorcetPHP\Condorcet\Algo\Tools\StvQuotas;
use CondorcetPHP\Condorcet\Condorcet;
use CondorcetPHP\Condorcet\Constraints\NoTie;
use CondorcetPHP\Condorcet\Election;
use CondorcetPHP\Condorcet\Result;
use CondorcetPHP\Condorcet\Tools\Converters\CEF\CondorcetElectionFormat;
use CondorcetPHP\Condorcet\Vote;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

/**
 * Main Livewire component for managing the entire Condorcet election.
 *
 * This component is **stateless** on the server: on every render it reconstructs
 * the full Election object from the public properties (which mirror the
 * localStorage JSON on the client) and computes all results from scratch.
 */
#[Layout('components.layouts.app')]
class ElectionManager extends Component
{
    use WithFileUploads;

    // ──────────────────────────────────────────────
    // Election state — synced with localStorage
    // ──────────────────────────────────────────────

    /** @var list<string> Candidate names */
    public array $candidates = [];

    /**
     * Votes list.
     *
     * Each entry: ['ranking' => string, 'weight' => int, 'quantity' => int]
     *
     * @var list<array{ranking: string, weight: int, quantity: int}>
     */
    public array $votes = [];

    /** @var list<string> Selected voting method aliases (defaults to the library's default method) */
    public array $methods = ['Schulze Winning'];

    /** Number of seats for proportional methods */
    public int $seats = 100;

    /** Whether unranked candidates are implicitly ranked last */
    public bool $implicitRanking = true;

    /** Whether vote weight is enabled */
    public bool $weightAllowed = true;

    /** Whether the NoTie constraint is active */
    public bool $noTieConstraint = false;

    // ──────────────────────────────────────────────
    // Form input fields (transient, not persisted)
    // ──────────────────────────────────────────────

    public string $newCandidate = '';

    public string $newVoteRanking = '';

    /** @var int|null Vote weight override (null = use weight from ranking string or default 1) */
    public ?int $newVoteWeight = null;

    public int $newVoteQuantity = 1;

    public string $importText = '';

    /** Bulk vote input for parseVotes modal */
    public string $parseVotesText = '';

    /** @var TemporaryUploadedFile|null Uploaded .cvotes file for import */
    public $importFile = null;

    // ──────────────────────────────────────────────
    // Per-method options
    // ──────────────────────────────────────────────

    /** Borda Count starting point (0 or 1) */
    public int $bordaStarting = 1;

    /** STV quota name */
    public string $stvQuota = 'Droop';

    /** CPO-STV quota name */
    public string $cpoStvQuota = 'Hagenbach-Bischoff';

    /** Sainte-Laguë first divisor (1 = standard, 1.4 = Norwegian) */
    public string $sainteLagueFirstDivisor = '1';

    /** Largest Remainder quota name */
    public string $largestRemainderQuota = 'Hare';

    // ──────────────────────────────────────────────
    // Computed output (non-persisted)
    // ──────────────────────────────────────────────

    /** Warnings generated during the last computation */
    public array $warnings = [];

    /** Exported .cvotes string */
    public string $exportOutput = '';

    // ─────────────────────────────────────────────────────────────
    //  Available voting methods grouped by family
    // ─────────────────────────────────────────────────────────────

    /**
     * Method classes considered "informational" (return a set, not a full ranking).
     *
     * These cannot be auto-detected from class constants, so we list them explicitly.
     *
     * @var list<class-string>
     */
    private const array INFORMATIONAL_METHOD_CLASSES = [
        SmithSet::class,
        SchwartzSet::class,
    ];

    /**
     * Return all voting methods organised by family, dynamically queried
     * from the Condorcet library.
     *
     * Each method is categorised by inspecting the class constants:
     * - IS_DETERMINISTIC = false → skipped (Random Ballot, Random Candidates)
     * - IS_PROPORTIONAL = true   → "Proportional"
     * - Class in INFORMATIONAL_METHOD_CLASSES → "Informational"
     * - Everything else          → "Single Winner"
     *
     * Keys are the method's first alias (understood by the library);
     * values are the same alias used as a human-readable label.
     *
     * @return array<string, array<string, string>>
     */
    public static function getMethodGroups(): array
    {
        $singleWinner = [];
        $proportional = [];
        $informational = [];

        foreach (Condorcet::getAuthMethods() as $methodName) {
            /** @var class-string $className */
            $className = Condorcet::getMethodClass($methodName);

            // Skip non-deterministic methods (e.g. Random Ballot, Random Candidates)
            if (! $className::IS_DETERMINISTIC) {
                continue;
            }

            if (in_array($className, self::INFORMATIONAL_METHOD_CLASSES, true)) {
                $informational[$methodName] = $methodName;
            } elseif ($className::IS_PROPORTIONAL) {
                $proportional[$methodName] = $methodName;
            } else {
                $singleWinner[$methodName] = $methodName;
            }
        }

        return [
            'Single Winner' => $singleWinner,
            'Proportional' => $proportional,
            'Informational' => $informational,
        ];
    }

    // ─────────────────────────────────────────────────────────────
    //  Candidate actions
    // ─────────────────────────────────────────────────────────────

    /**
     * Add one or more candidates from the text input.
     *
     * Supports semicolon-separated lists (e.g. "Alice ; Bob ; Charlie")
     * as well as single names. Duplicates are silently skipped.
     */
    public function addCandidate(): void
    {
        $input = mb_trim($this->newCandidate);

        if ($input === '') {
            $this->addError('newCandidate', __('ui.error_candidate_empty'));

            return;
        }

        $names = array_map(static fn ($name) => mb_trim($name), explode(';', $input));
        $added = 0;

        foreach ($names as $name) {
            if ($name !== '' && ! in_array($name, $this->candidates, true)) {
                $this->candidates[] = $name;
                $added++;
            }
        }

        if ($added === 0) {
            $this->addError('newCandidate', __('ui.error_candidate_exists'));

            return;
        }

        $this->newCandidate = '';
        $this->syncState();
    }

    /**
     * Remove a candidate by its index.
     */
    public function removeCandidate(int $index): void
    {
        unset($this->candidates[$index]);
        $this->candidates = array_values($this->candidates);
        $this->syncState();
    }

    // ─────────────────────────────────────────────────────────────
    //  Vote actions
    // ─────────────────────────────────────────────────────────────

    /**
     * Add a single vote from the form inputs.
     *
     * Uses the Condorcet Vote object to parse the ranking string, which
     * handles embedded weight (^N) and tags automatically. The form
     * weight field overrides the embedded weight when explicitly filled.
     */
    public function addVote(): void
    {
        $ranking = mb_trim($this->newVoteRanking);

        if ($ranking === '') {
            $this->addError('newVoteRanking', __('ui.error_vote_empty'));

            return;
        }

        // Let the library parse the ranking string (handles ^weight, tags, etc.)
        $vote = new Vote($ranking);

        // Extract the clean ranking and the parsed weight from the Vote object
        $parsedWeight = $vote->getWeight();
        $cleanRanking = $vote->getRankingAsString(displayWeight: false);

        // Form weight overrides embedded weight when explicitly set
        $weight = ($this->weightAllowed && $this->newVoteWeight !== null)
            ? max(1, $this->newVoteWeight)
            : ($this->weightAllowed ? $parsedWeight : 1);

        // Quantity is only from the form (not embedded in ranking string)
        $quantity = max(1, $this->newVoteQuantity);

        $this->votes[] = [
            'ranking' => $cleanRanking,
            'weight' => $weight,
            'quantity' => $quantity,
        ];

        $this->newVoteRanking = '';
        $this->newVoteWeight = null;
        $this->newVoteQuantity = 1;
        $this->syncState();
    }

    /**
     * Remove a vote by its index.
     */
    public function removeVote(int $index): void
    {
        unset($this->votes[$index]);
        $this->votes = array_values($this->votes);
        $this->syncState();
    }

    /**
     * Bulk-add votes from a multi-line text using the Condorcet parseVotes format.
     *
     * Each line follows the same syntax as .cvotes vote lines:
     *   ranking ^weight * quantity
     *
     * Lines are parsed individually so that each entry preserves its own
     * weight and quantity in the stored votes array. Comment lines (#)
     * and blank lines are silently skipped.
     */
    public function bulkAddVotes(): void
    {
        $text = mb_trim($this->parseVotesText);

        if ($text === '') {
            $this->addError('parseVotesText', __('ui.error_parse_votes_empty'));

            return;
        }

        if (count($this->candidates) < 2) {
            $this->addError('parseVotesText', __('ui.error_parse_votes_need_candidates'));

            return;
        }

        $added = 0;

        try {
            $lines = preg_split('/\r?\n/', $text);

            foreach ($lines as $line) {
                $line = mb_trim($line);

                // Skip blank lines and comment lines
                if ($line === '' || str_starts_with($line, '#')) {
                    continue;
                }

                // Extract quantity suffix (* N)
                $quantity = 1;
                if (preg_match('/\*\s*(\d+)\s*$/', $line, $matches)) {
                    $quantity = max(1, (int) $matches[1]);
                    $line = mb_trim(preg_replace('/\*\s*\d+\s*$/', '', $line));
                }

                // Let the Vote class parse ranking + optional ^weight
                $vote = new Vote($line);

                $this->votes[] = [
                    'ranking' => $vote->getRankingAsString(displayWeight: false),
                    'weight' => $this->weightAllowed ? $vote->getWeight() : 1,
                    'quantity' => $quantity,
                ];

                $added++;
            }

            if ($added === 0) {
                $this->addError('parseVotesText', __('ui.error_parse_votes_empty'));

                return;
            }

            $this->parseVotesText = '';
            $this->syncState();
            $this->dispatch('bulk-votes-added');
        } catch (\Throwable $e) {
            $this->addError('parseVotesText', __('ui.error_parse_votes_failed', ['message' => $e->getMessage()]));
        }
    }

    // ─────────────────────────────────────────────────────────────
    //  Method selection
    // ─────────────────────────────────────────────────────────────

    /**
     * Toggle a voting method on or off.
     */
    public function toggleMethod(string $method): void
    {
        if (in_array($method, $this->methods, true)) {
            $this->methods = array_values(array_diff($this->methods, [$method]));
        } else {
            $this->methods[] = $method;
        }

        $this->syncState();
    }

    /**
     * Called when the methods property is set via $wire.$set().
     *
     * Ensures syncState fires so localStorage is updated even when
     * methods arrives as a property update rather than a method call.
     */
    public function updatedMethods(): void
    {
        $this->methods = array_values($this->methods);
        $this->syncState();
    }

    // ─────────────────────────────────────────────────────────────
    //  Configuration changes
    // ─────────────────────────────────────────────────────────────

    /**
     * Called whenever a configuration option changes.
     *
     * Any public property update triggers a Livewire re-render, so
     * this method only needs to sync the state to localStorage.
     */
    public function updatedImplicitRanking(): void
    {
        $this->syncState();
    }

    public function updatedWeightAllowed(): void
    {
        $this->syncState();
    }

    public function updatedNoTieConstraint(): void
    {
        $this->syncState();
    }

    public function updatedSeats(): void
    {
        $this->seats = max(1, $this->seats);
        $this->syncState();
    }

    public function updatedBordaStarting(): void
    {
        $this->syncState();
    }

    public function updatedStvQuota(): void
    {
        $this->syncState();
    }

    public function updatedCpoStvQuota(): void
    {
        $this->syncState();
    }

    public function updatedSainteLagueFirstDivisor(): void
    {
        $this->syncState();
    }

    public function updatedLargestRemainderQuota(): void
    {
        $this->syncState();
    }

    // ─────────────────────────────────────────────────────────────
    //  Import / Export
    // ─────────────────────────────────────────────────────────────

    /**
     * Import an election from CondorcetElectionFormat (.cvotes) text.
     */
    public function importCvotes(): void
    {
        $text = mb_trim($this->importText);

        if ($text === '') {
            $this->addError('importText', __('ui.error_import_empty'));

            return;
        }

        try {
            $cef = CondorcetElectionFormat::createFromString($text);
            $election = $cef->setDataToAnElection();

            // Extract candidates
            $this->candidates = $election->getCandidatesListAsString();

            // Extract configuration
            $this->implicitRanking = $election->implicitRankingRule;
            $this->weightAllowed = $election->authorizeVoteWeight;
            $this->seats = $election->seatsToElect;

            // Extract votes
            $this->votes = [];
            foreach ($election->getVotesList() as $vote) {
                $this->votes[] = [
                    'ranking' => $vote->getRankingAsString(context: $election, displayWeight: false),
                    'weight' => $vote->getWeight($election),
                    'quantity' => 1,
                ];
            }

            $this->importText = '';
            $this->syncState();
        } catch (\Throwable $e) {
            $this->addError('importText', __('ui.error_import_failed', ['message' => $e->getMessage()]));
        }
    }

    /**
     * Import election data from an uploaded .cvotes file.
     *
     * Reads the file content server-side and delegates to the same
     * import logic used by importCvotes().
     */
    public function importFromFile(): void
    {
        $this->validate([
            'importFile' => ['required', 'file', 'max:51200'], // 50 MB max
        ]);

        try {
            $this->importText = $this->importFile->get();
            $this->importCvotes();
        } catch (\Throwable $e) {
            $this->addError('importFile', __('ui.error_file_import_failed', ['message' => $e->getMessage()]));
        } finally {
            $this->importFile = null;
        }
    }

    /**
     * Export the current election to CondorcetElectionFormat (.cvotes) string.
     */
    public function exportCvotes(): void
    {
        if (count($this->candidates) < 2) {
            $this->addError('exportOutput', __('ui.error_export_min_candidates'));

            return;
        }

        try {
            $election = $this->buildElection();

            if ($election === null) {
                $this->addError('exportOutput', __('ui.error_export_build_failed'));

                return;
            }

            $this->exportOutput = CondorcetElectionFormat::createFromElection($election) ?? '';
        } catch (\Throwable $e) {
            $this->addError('exportOutput', __('ui.error_export_failed', ['message' => $e->getMessage()]));
        }
    }

    // ─────────────────────────────────────────────────────────────
    //  Load state from localStorage (called from Alpine on mount)
    // ─────────────────────────────────────────────────────────────

    /**
     * Hydrate the component with state from localStorage.
     *
     * @param  array<string, mixed>  $state
     */
    public function loadFromLocalStorage(array $state): void
    {
        $this->candidates = $state['candidates'] ?? [];
        $this->votes = $state['votes'] ?? [];
        $this->methods = $state['methods'] ?? [];
        $this->seats = max(1, (int) ($state['seats'] ?? 1));
        $this->implicitRanking = (bool) ($state['implicitRanking'] ?? true);
        $this->weightAllowed = (bool) ($state['weightAllowed'] ?? false);
        $this->noTieConstraint = (bool) ($state['noTieConstraint'] ?? false);
        $this->syncState();
    }

    /**
     * Reset the entire election to a blank state.
     */
    public function resetElection(): void
    {
        $this->candidates = [];
        $this->votes = [];
        $this->methods = [Condorcet::getDefaultMethod()::METHOD_NAME[0]];
        $this->seats = 100;
        $this->implicitRanking = true;
        $this->weightAllowed = true;
        $this->noTieConstraint = false;
        $this->exportOutput = '';
        $this->syncState();
    }

    // ─────────────────────────────────────────────────────────────
    //  Render — recompute everything on every cycle
    // ─────────────────────────────────────────────────────────────

    public function render(): \Illuminate\Contracts\View\View
    {
        $this->warnings = [];
        $computedResults = $this->computeResults();

        return view('livewire.election-manager', [
            'computedResults' => $computedResults,
            'methodGroups' => static::getMethodGroups(),
            'quotaOptions' => $this->getQuotaOptions(),
            'activeMethodOptions' => $this->getActiveMethodOptions(),
            'defaultMethod' => Condorcet::getDefaultMethod(),
            'condorcetVersion' => Condorcet::getVersion(),
            'appVersion' => config('version.app'),
        ]);
    }

    // ─────────────────────────────────────────────────────────────
    //  Private helpers
    // ─────────────────────────────────────────────────────────────

    /**
     * Dispatch a browser event so Alpine can persist state to localStorage.
     */
    protected function syncState(): void
    {
        $this->dispatch('election-state-updated', state: [
            'candidates' => $this->candidates,
            'votes' => $this->votes,
            'methods' => $this->methods,
            'seats' => $this->seats,
            'implicitRanking' => $this->implicitRanking,
            'weightAllowed' => $this->weightAllowed,
            'noTieConstraint' => $this->noTieConstraint,
        ]);
    }

    /**
     * Build an Election object from the current component state.
     *
     * Returns null when insufficient data is available.
     *
     * When the optional `$voteRepresentatives` array is passed by reference, it
     * will be populated with one representative Vote object per source vote index.
     * This allows the caller to check constraint validity per original vote entry
     * without re-creating Vote objects.
     *
     * @param  array<int, Vote>|null  &$voteRepresentatives  Populated with one Vote per source index (optional).
     */
    protected function buildElection(?array &$voteRepresentatives = null): ?Election
    {
        if (count($this->candidates) < 2) {
            return null;
        }

        $election = new Election;

        // Add candidates
        foreach ($this->candidates as $candidate) {
            $election->addCandidate($candidate);
        }

        // Configure election rules
        $election->implicitRankingRule($this->implicitRanking);
        $election->authorizeVoteWeight($this->weightAllowed);
        $election->setSeatsToElect(max(1, $this->seats));

        if ($this->noTieConstraint) {
            $election->addConstraint(NoTie::class);
        }

        // Apply method-specific options
        $this->applyMethodOptions($election);

        // Initialise the representative tracking array when requested
        if ($voteRepresentatives !== null) {
            $voteRepresentatives = [];
        }

        // Add votes by creating Vote objects from stored data
        if (count($this->votes) > 0) {
            foreach ($this->votes as $sourceIndex => $voteData) {
                try {
                    $quantity = max(1, $voteData['quantity'] ?? 1);

                    // Create each vote instance individually
                    for ($i = 0; $i < $quantity; $i++) {
                        $vote = new Vote($voteData['ranking'], electionContext: $election);

                        if ($this->weightAllowed && ($voteData['weight'] ?? 1) >= 1) {
                            $vote->setWeight($voteData['weight']);
                        }

                        $election->addVote($vote);

                        // Keep the first expanded Vote as the representative for this source entry
                        if ($voteRepresentatives !== null && $i === 0) {
                            $voteRepresentatives[$sourceIndex] = $vote;
                        }
                    }
                } catch (\Throwable $e) {
                    $this->warnings[] = __('ui.warning_vote_error', ['message' => $e->getMessage()]);
                }
            }
        }

        return $election;
    }

    /**
     * Apply per-method options to the Election.
     */
    protected function applyMethodOptions(Election $election): void
    {
        // Borda Count starting point
        $election->setMethodOption(BordaCount::class, 'Starting', $this->bordaStarting);

        // STV quota
        $stvQuota = $this->resolveQuota($this->stvQuota);
        if ($stvQuota !== null) {
            $election->setMethodOption(SingleTransferableVote::class, 'Quota', $stvQuota);
        }

        // CPO-STV quota
        $cpoQuota = $this->resolveQuota($this->cpoStvQuota);
        if ($cpoQuota !== null) {
            $election->setMethodOption(CPO_STV::class, 'Quota', $cpoQuota);
        }

        // Sainte-Laguë first divisor
        $election->setMethodOption(SainteLague::class, 'FirstDivisor', (float) $this->sainteLagueFirstDivisor);

        // Largest Remainder quota
        $lrQuota = $this->resolveQuota($this->largestRemainderQuota);
        if ($lrQuota !== null) {
            $election->setMethodOption(LargestRemainder::class, 'Quota', $lrQuota);
        }
    }

    /**
     * Resolve a quota name string to the StvQuotas enum case.
     *
     * Delegates to the library's own `StvQuotas::fromString()` which
     * accepts both short names ("Droop") and full names ("Droop Quota").
     */
    protected function resolveQuota(string $name): ?StvQuotas
    {
        try {
            return StvQuotas::fromString($name);
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Return the active per-method options for a given method alias.
     *
     * Discovers options dynamically by inspecting static `$option*`
     * properties on the method class via reflection. Also includes
     * `$MaxCandidates` when explicitly set (non-null).
     *
     * Scalar and enum values are displayed; arrays are skipped
     * (e.g. CPO-STV tie-breaker lists) as they are not user-facing.
     *
     * @return array<string, string>
     */
    protected function getMethodOptionsForDisplay(string $method): array
    {
        $class = Condorcet::getMethodClass($method);
        $reflection = new \ReflectionClass($class);
        $options = [];

        foreach ($reflection->getStaticProperties() as $property => $value) {
            // Include $option* properties and $MaxCandidates (when non-null)
            if (str_starts_with($property, 'option')) {
                $label = substr($property, 6); // strip 'option' prefix
            } elseif ($property === 'MaxCandidates' && $value !== null) {
                $label = $property;
            } else {
                continue;
            }

            // Skip arrays (not useful for display, e.g. tie-breaker method lists)
            if (is_array($value)) {
                continue;
            }

            // Format the value for display
            $display = match (true) {
                $value instanceof \BackedEnum => $value->value,
                $value instanceof \UnitEnum => $value->name,
                is_bool($value) => $value ? 'true' : 'false',
                default => (string) $value,
            };

            $options[$label] = $display;
        }

        return $options;
    }

    /**
     * Return available quota options for the UI selectors.
     *
     * Derived dynamically from the StvQuotas enum cases. Each case
     * value has the format "Name Quota" — we strip the " Quota" suffix
     * to get the short display name (e.g. "Droop", "Hare").
     *
     * @return list<string>
     */
    protected function getQuotaOptions(): array
    {
        return array_map(
            fn (StvQuotas $case): string => str_replace(' Quota', '', $case->value),
            StvQuotas::cases(),
        );
    }

    /**
     * Build form descriptors for all configurable method options.
     *
     * This is the single source of truth for the method-options UI.
     * Each method alias maps to an array of option descriptors with:
     *   - wire:    Livewire property name (for wire:model binding)
     *   - label:   Translation key for the form label
     *   - type:    'select' | 'number' | 'quota' (quota = StvQuotas selector)
     *   - choices: (select only) array of ['value' => mixed, 'label' => string]
     *   - min, max, step, placeholder: (number only) HTML input attributes
     *   - hint:    Optional translation key for help text below the input
     *
     * @return array<string, list<array<string, mixed>>>
     */
    protected function getMethodOptionRegistry(): array
    {
        return [
            BordaCount::METHOD_NAME[0] => [
                [
                    'wire' => 'bordaStarting',
                    'label' => __('ui.borda_starting'),
                    'type' => 'select',
                    'choices' => [
                        ['value' => 1, 'label' => __('ui.borda_standard')],
                        ['value' => 0, 'label' => '0'],
                    ],
                ],
            ],
            SingleTransferableVote::METHOD_NAME[0] => [
                [
                    'wire' => 'stvQuota',
                    'label' => __('ui.stv_quota'),
                    'type' => 'quota',
                ],
            ],
            CPO_STV::METHOD_NAME[0] => [
                [
                    'wire' => 'cpoStvQuota',
                    'label' => __('ui.cpo_stv_quota'),
                    'type' => 'quota',
                ],
            ],
            SainteLague::METHOD_NAME[0] => [
                [
                    'wire' => 'sainteLagueFirstDivisor',
                    'label' => __('ui.sainte_lague_divisor'),
                    'type' => 'number',
                    'min' => 1,
                    'step' => 0.1,
                    'hint' => __('ui.sainte_lague_hint'),
                ],
            ],
            LargestRemainder::METHOD_NAME[0] => [
                [
                    'wire' => 'largestRemainderQuota',
                    'label' => __('ui.largest_remainder_quota'),
                    'type' => 'quota',
                ],
            ],
        ];
    }

    /**
     * Return form descriptors for method options that match the currently
     * selected voting methods.
     *
     * @return list<array<string, mixed>>
     */
    protected function getActiveMethodOptions(): array
    {
        $registry = $this->getMethodOptionRegistry();
        $active = [];

        foreach ($this->methods as $method) {
            if (isset($registry[$method])) {
                array_push($active, ...$registry[$method]);
            }
        }

        return $active;
    }

    /**
     * Compute results for all selected methods.
     *
     * Returns a structured array with Condorcet winner/loser, pairwise
     * matrix, and per-method rankings, winners, losers, and stats.
     *
     * @return array{
     *     empty: bool,
     *     condorcetWinner: string|null,
     *     condorcetLoser: string|null,
     *     pairwise: array,
     *     results: array<string, array{ranking: array, winner: string|null, loser: string|null, stats: array}>,
     *     countVotes: int,
     *     sumVoteWeights: int,
     *     countValidVotes: int,
     *     sumValidVoteWeights: int,
     *     voteValidity: array<int, bool>
     * }
     */
    protected function computeResults(): array
    {
        // Not enough data to compute
        if (count($this->candidates) < 2 || count($this->votes) === 0) {
            return [
                'empty' => true,
                'condorcetWinner' => null,
                'condorcetLoser' => null,
                'pairwise' => [],
                'results' => [],
                'countVotes' => 0,
                'sumVoteWeights' => 0,
                'countValidVotes' => 0,
                'sumValidVoteWeights' => 0,
                'voteValidity' => [],
            ];
        }

        $voteRepresentatives = [];
        $election = $this->buildElection($voteRepresentatives);

        if ($election === null || $election->countVotes() === 0) {
            return [
                'empty' => true,
                'condorcetWinner' => null,
                'condorcetLoser' => null,
                'pairwise' => [],
                'results' => [],
                'countVotes' => 0,
                'sumVoteWeights' => 0,
                'countValidVotes' => 0,
                'sumValidVoteWeights' => 0,
                'voteValidity' => [],
            ];
        }

        // Condorcet winner / loser (method-independent)
        $condorcetWinner = $election->getCondorcetWinner();
        $condorcetLoser = $election->getCondorcetLoser();

        // Pairwise matrix
        $pairwise = [];
        try {
            $pairwise = $election->getExplicitPairwise();
        } catch (\Throwable $e) {
            $this->warnings[] = __('ui.warning_pairwise_error', ['message' => $e->getMessage()]);
        }

        // Per-method results
        $results = [];
        foreach ($this->methods as $method) {
            try {
                $result = $election->getResult($method);

                // Build a serializable ranking array
                $ranking = [];
                foreach ($result->rankingAsArrayString as $rank => $candidates) {
                    $ranking[$rank] = is_array($candidates) ? $candidates : [$candidates];
                }

                // Extract winner and loser as strings
                $winner = $result->Winner;
                $loser = $result->Loser;

                // Detect if the method is informational (e.g. Smith Set, Schwartz Set)
                $methodClass = Condorcet::getMethodClass($method);
                $isInformational = in_array($methodClass, self::INFORMATIONAL_METHOD_CLASSES, true);

                /**
                 * Format a method winner/loser value as a string.
                 *
                 * The Condorcet library returns either a single Candidate object
                 * (clear winner/loser) or an array of Candidates (tie), or null.
                 * This closure normalises all three cases into a display string.
                 */
                $formatCandidate = static fn (\CondorcetPHP\Condorcet\Candidate|array|null $value): ?string => match (true) {
                    $value instanceof \CondorcetPHP\Condorcet\Candidate => (string) $value,
                    is_array($value) => implode(' = ', array_map(static fn (\CondorcetPHP\Condorcet\Candidate $c): string => (string) $c, $value)),
                    default => null,
                };

                $results[$method] = [
                    'ranking' => $ranking,
                    'winner' => $formatCandidate($winner),
                    'loser' => $formatCandidate($loser),
                    'stats' => $this->serializeStats($result),
                    'isProportional' => $result->isProportional,
                    'isInformational' => $isInformational,
                    'seats' => $result->seats,
                    'methodOptions' => $this->getMethodOptionsForDisplay($method),
                ];
            } catch (\Throwable $e) {
                $this->warnings[] = "{$method}: {$e->getMessage()}";
            }
        }

        // Sort results alphabetically by method name for consistent display
        ksort($results, SORT_NATURAL | SORT_FLAG_CASE);

        // Build per-source-vote constraint validity map.
        // Only populated when at least one constraint is active, so the view
        // can distinguish between "no constraints" (empty array) and
        // "constraints present, all votes valid" (all-true array).
        $voteValidity = [];
        if ($this->noTieConstraint) {
            foreach ($voteRepresentatives as $sourceIndex => $representativeVote) {
                $voteValidity[$sourceIndex] = $election->isVoteValidUnderConstraints($representativeVote);
            }
        }

        return [
            'empty' => false,
            'condorcetWinner' => $condorcetWinner !== null ? (string) $condorcetWinner : null,
            'condorcetLoser' => $condorcetLoser !== null ? (string) $condorcetLoser : null,
            'pairwise' => $pairwise,
            'results' => $results,
            'countVotes' => $election->countVotes(),
            'sumVoteWeights' => $election->sumVoteWeights(),
            'countValidVotes' => $election->countValidVoteWithConstraints(),
            'sumValidVoteWeights' => $election->sumValidVoteWeightsWithConstraints(),
            'voteValidity' => $voteValidity,
            'timer' => $election->getGlobalTimer(),
        ];
    }

    /**
     * Serialize a Result's stats to a plain array for display.
     *
     * @return array<string, mixed>
     */
    protected function serializeStats(Result $result): array
    {
        try {
            return $result->stats->asArray;
        } catch (\Throwable) {
            return [];
        }
    }
}
