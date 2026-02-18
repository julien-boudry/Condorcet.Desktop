<?php

namespace App\Livewire;

use CondorcetPHP\Condorcet\Algo\Methods\KemenyYoung\KemenyYoung;
use CondorcetPHP\Condorcet\Algo\Methods\Smith\SchwartzSet;
use CondorcetPHP\Condorcet\Algo\Methods\Smith\SmithSet;
use CondorcetPHP\Condorcet\Algo\Tools\StvQuotas;
use CondorcetPHP\Condorcet\Condorcet;
use CondorcetPHP\Condorcet\Constraints\NoTie;
use CondorcetPHP\Condorcet\Election;
use CondorcetPHP\Condorcet\Tools\Converters\CEF\CondorcetElectionFormat;
use Livewire\Attributes\Layout;
use Livewire\Component;

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
    public int $seats = 1;

    /** Whether unranked candidates are implicitly ranked last */
    public bool $implicitRanking = true;

    /** Whether vote weight is enabled */
    public bool $weightAllowed = false;

    /** Whether the NoTie constraint is active */
    public bool $noTieConstraint = false;

    // ──────────────────────────────────────────────
    // Form input fields (transient, not persisted)
    // ──────────────────────────────────────────────

    public string $newCandidate = '';

    public string $newVoteRanking = '';

    public int $newVoteWeight = 1;

    public int $newVoteQuantity = 1;

    public string $importText = '';

    // ──────────────────────────────────────────────
    // Per-method options
    // ──────────────────────────────────────────────

    /** Borda Count starting point (0 or 1) */
    public int $bordaStarting = 1;

    /** Kemeny–Young maximum candidates (null = no limit) */
    public ?int $kemenyMaxCandidates = 10;

    /** STV quota name */
    public string $stvQuota = 'Droop';

    /** CPO-STV quota name */
    public string $cpoStvQuota = 'Hagenbach-Bischoff';

    /** Sainte-Laguë first divisor (1 = standard, 1.4 = Norwegian) */
    public float $sainteLagueFirstDivisor = 1.0;

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
     * - IS_PROPORTIONAL = true  → "Proportional"
     * - Class in INFORMATIONAL_METHOD_CLASSES → "Informational"
     * - Everything else         → "Single Winner"
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
        $input = trim($this->newCandidate);

        if ($input === '') {
            $this->addError('newCandidate', 'Candidate name cannot be empty.');

            return;
        }

        $names = array_map('trim', explode(';', $input));
        $added = 0;

        foreach ($names as $name) {
            if ($name !== '' && ! in_array($name, $this->candidates, true)) {
                $this->candidates[] = $name;
                $added++;
            }
        }

        if ($added === 0) {
            $this->addError('newCandidate', 'All candidates already exist or input is invalid.');

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
     */
    public function addVote(): void
    {
        $ranking = trim($this->newVoteRanking);

        if ($ranking === '') {
            $this->addError('newVoteRanking', 'Vote ranking cannot be empty.');

            return;
        }

        $this->votes[] = [
            'ranking' => $ranking,
            'weight' => $this->weightAllowed ? max(1, $this->newVoteWeight) : 1,
            'quantity' => max(1, $this->newVoteQuantity),
        ];

        $this->newVoteRanking = '';
        $this->newVoteWeight = 1;
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

    public function updatedKemenyMaxCandidates(): void
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
        $text = trim($this->importText);

        if ($text === '') {
            $this->addError('importText', 'Paste some .cvotes content first.');

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
            $this->addError('importText', 'Import failed: '.$e->getMessage());
        }
    }

    /**
     * Export the current election to CondorcetElectionFormat (.cvotes) string.
     */
    public function exportCvotes(): void
    {
        if (count($this->candidates) < 2) {
            $this->addError('exportOutput', 'Need at least 2 candidates to export.');

            return;
        }

        try {
            $election = $this->buildElection();

            if ($election === null) {
                $this->addError('exportOutput', 'Could not build election.');

                return;
            }

            $this->exportOutput = CondorcetElectionFormat::createFromElection($election) ?? '';
        } catch (\Throwable $e) {
            $this->addError('exportOutput', 'Export failed: '.$e->getMessage());
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
    }

    /**
     * Reset the entire election to a blank state.
     */
    public function resetElection(): void
    {
        $this->candidates = [];
        $this->votes = [];
        $this->methods = [Condorcet::getDefaultMethod()::METHOD_NAME[0]];
        $this->seats = 1;
        $this->implicitRanking = true;
        $this->weightAllowed = false;
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
            'defaultMethod' => Condorcet::getDefaultMethod(),
            'condorcetVersion' => Condorcet::getVersion(),
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
        ]);
    }

    /**
     * Build an Election object from the current component state.
     *
     * Returns null when insufficient data is available.
     */
    protected function buildElection(): ?Election
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

        // Add votes using parseVotes for full format support (^weight, *quantity)
        if (count($this->votes) > 0) {
            $voteLines = [];

            foreach ($this->votes as $vote) {
                $line = $vote['ranking'];

                if ($this->weightAllowed && ($vote['weight'] ?? 1) > 1) {
                    $line .= ' ^'.$vote['weight'];
                }

                if (($vote['quantity'] ?? 1) > 1) {
                    $line .= ' * '.$vote['quantity'];
                }

                $voteLines[] = $line;
            }

            try {
                $election->parseVotes(implode("\n", $voteLines));
            } catch (\Throwable $e) {
                $this->warnings[] = 'Vote parsing error: '.$e->getMessage();
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
        $election->setMethodOption('BordaCount', 'Starting', $this->bordaStarting);

        // Kemeny–Young max candidates
        KemenyYoung::$MaxCandidates = $this->kemenyMaxCandidates;

        // STV quota
        $stvQuota = $this->resolveQuota($this->stvQuota);
        if ($stvQuota !== null) {
            $election->setMethodOption('STV', 'Quota', $stvQuota);
        }

        // CPO-STV quota
        $cpoQuota = $this->resolveQuota($this->cpoStvQuota);
        if ($cpoQuota !== null) {
            $election->setMethodOption('CPO STV', 'Quota', $cpoQuota);
        }

        // Sainte-Laguë first divisor
        $election->setMethodOption('SainteLague', 'FirstDivisor', $this->sainteLagueFirstDivisor);

        // Largest Remainder quota
        $lrQuota = $this->resolveQuota($this->largestRemainderQuota);
        if ($lrQuota !== null) {
            $election->setMethodOption('LargestRemainder', 'Quota', $lrQuota);
        }
    }

    /**
     * Resolve a quota name string to the StvQuotas enum case.
     */
    protected function resolveQuota(string $name): ?StvQuotas
    {
        return match ($name) {
            'Droop' => StvQuotas::DROOP,
            'Hare' => StvQuotas::HARE,
            'Hagenbach-Bischoff' => StvQuotas::HAGENBACH_BISCHOFF,
            'Imperiali' => StvQuotas::IMPERIALI,
            default => null,
        };
    }

    /**
     * Return available quota options for the UI selectors.
     *
     * @return list<string>
     */
    protected function getQuotaOptions(): array
    {
        return ['Droop', 'Hare', 'Hagenbach-Bischoff', 'Imperiali'];
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
     *     results: array<string, array{ranking: array, winner: string|null, loser: string|null, stats: array}>
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
            ];
        }

        $election = $this->buildElection();

        if ($election === null || $election->countVotes() === 0) {
            return [
                'empty' => true,
                'condorcetWinner' => null,
                'condorcetLoser' => null,
                'pairwise' => [],
                'results' => [],
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
            $this->warnings[] = 'Pairwise error: '.$e->getMessage();
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

                $results[$method] = [
                    'ranking' => $ranking,
                    'winner' => $winner instanceof \CondorcetPHP\Condorcet\Candidate ? (string) $winner : (is_array($winner) ? implode(' = ', array_map('strval', $winner)) : null),
                    'loser' => $loser instanceof \CondorcetPHP\Condorcet\Candidate ? (string) $loser : (is_array($loser) ? implode(' = ', array_map('strval', $loser)) : null),
                    'stats' => $this->serializeStats($result),
                    'isProportional' => $result->isProportional,
                    'seats' => $result->seats,
                ];
            } catch (\Throwable $e) {
                $this->warnings[] = "{$method}: {$e->getMessage()}";
            }
        }

        return [
            'empty' => false,
            'condorcetWinner' => $condorcetWinner !== null ? (string) $condorcetWinner : null,
            'condorcetLoser' => $condorcetLoser !== null ? (string) $condorcetLoser : null,
            'pairwise' => $pairwise,
            'results' => $results,
        ];
    }

    /**
     * Serialize a Result's stats to a plain array for display.
     *
     * @return array<string, mixed>
     */
    protected function serializeStats(\CondorcetPHP\Condorcet\Result $result): array
    {
        try {
            return $result->stats->asArray;
        } catch (\Throwable) {
            return [];
        }
    }
}
