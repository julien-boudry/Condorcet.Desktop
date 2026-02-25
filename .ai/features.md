# Feature Specifications

> **Implementation status:** All features below are implemented. Each section notes the file(s) responsible. See [architecture.md](architecture.md) for the overall structure.

## 1. Election Setup

### Candidates
- Add candidates via a **form** (one by one, fluid UX with minimal JS)
- **OR** paste a **semicolon-separated list** (e.g. `Alice;Bob;Charlie`) — the library parses this natively
- Display current candidates list; allow removing individual candidates

> **Implemented in:** `ElectionManager::addCandidate()`, `addCandidatesBulk()`, `removeCandidate()`
> **View:** `partials/candidate-panel.blade.php`
> **Implementation choice:** Bulk add splits on `;` and skips duplicates silently. Single add shows validation error on empty or duplicate names.

### Votes
- Add votes **one by one** via a ranked-ballot form (format: `Alice > Bob > Charlie`, ties: `Alice = Bob > Charlie`)
- **Bulk add** via a modal popup accepting the Condorcet `parseVotes` format — one vote per line, with optional `^weight` and `* quantity` suffixes; comment lines (`#`) and blank lines are skipped
- **OR** paste raw **CondorcetElectionFormat (`.cvotes`)** text — see the format reference in [condorcet-library.md](condorcet-library.md)
- Display current vote list in a dedicated **Votes tab** in the results area; allow removing individual votes from there

> **Implemented in:** `ElectionManager::addVote()`, `removeVote()`, `bulkAddVotes()`
> **View:** `partials/vote-panel.blade.php` (sidebar: single-vote form + bulk add button/modal), `partials/votes-tab.blade.php` (results area: full vote table)
> **Implementation choice:** Votes are stored as `['ranking' => string, 'weight' => int, 'quantity' => int]`. When building the Election, vote lines are assembled with `^weight` and `* quantity` suffixes and fed to `$election->parseVotes()`. This delegates all parsing (ties, weights, quantities) to the library. Bulk add parses each line individually via `new Vote($line)`, extracting `* N` quantity suffix before parsing so each entry preserves its own quantity rather than expanding into N separate Vote objects.

---

## 2. Election Configuration

### General Options
- **Implicit vs. explicit ranking mode** (`implicitRankingRule(bool)`) — affects how unranked candidates are treated; pedagogically important, should be clearly explained in the UI
- **Vote weight** — allow setting a weight on individual votes; demonstrate its effect on results
- **Vote constraints** — at minimum expose the `NoTie` constraint (recommended by the library for several proportional methods)

> **Implemented in:** `ElectionManager` public properties `$implicitRanking`, `$weightAllowed`, `$noTieConstraint` with `updated*()` hooks
> **View:** `partials/config-panel.blade.php`
> **Implementation choice:** Config changes use `wire:model.live` checkboxes so results update immediately. The weight input field in the vote panel only appears when `$weightAllowed` is true.

### Proportional Mode
- **Number of seats** (`setSeatsToElect(int)`) — required for all proportional methods (STV, D'Hondt, Sainte-Laguë, LR families)
- When a proportional method is selected, show the seats configuration prominently

> **Implemented in:** `ElectionManager::$seats` property, enforced `max(1, …)` in `updatedSeats()`
> **View:** `partials/config-panel.blade.php`

---

## 3. Voting Methods Selection

- Allow selecting **one or multiple voting methods simultaneously**
- Methods are grouped by family:
  - **Single winner**: Schulze (Winning/Margin/Ratio), Ranked Pairs (Margin/Winning), Borda Count, Dowdall, Copeland, Instant-runoff, Kemeny-Young, FPTP, Multiple Rounds, Minimax (Winning/Margin/Opposition), Dodgson (Quick/Tideman), Random Ballot, Random Candidates
  - **Proportional**: STV, CPO-STV, Sainte-Laguë, D'Hondt (Jefferson), Largest Remainder (Hare/Droop/Imperiali/Hagenbach-Bischoff)
  - **Informational**: Smith set, Schwartz set

> **Implemented in:** `ElectionManager::getMethodGroups()` (static), `toggleMethod()`
> **View:** `partials/method-selector.blade.php`
> **Implementation choice:** Methods are grouped in a static array mapping method aliases (as understood by the library) to human-readable labels. The UI renders checkboxes grouped under collapsible headings. Toggling dispatches `toggleMethod($alias)`.

### Per-Method Options
Expose relevant method options via the UI:
- **Borda Count** — starting point (default 1, can be set to 0)
- **Kemeny-Young** — maximum candidates limit (default 10, configurable, or null for no limit)
- **STV / CPO-STV** — quota choice (Droop, Hare, Hagenbach-Bischoff, Imperiali)
- **Sainte-Laguë** — first divisor (1 = standard, 1.4 = Norwegian variant, etc.)
- **Largest Remainder** — quota choice (Hare, Droop, Hagenbach-Bischoff, Imperiali)

> **Implemented in:** `ElectionManager::applyMethodOptions()`, `resolveQuota()`
> **View:** Conditional section at the bottom of `partials/method-selector.blade.php`
> **Implementation choice:** Per-method options are stored as dedicated Livewire properties (`$bordaStarting`, `$kemenyMaxCandidates`, `$stvQuota`, `$cpoStvQuota`, `$sainteLagueFirstDivisor`, `$largestRemainderQuota`). The options panel only appears when the relevant method is selected. Quota names are resolved to `StvQuotas` enum cases via a match expression in `resolveQuota()`.

---

## 4. Results Display

### Per Method
- **Full ranking** — complete ordered list (with ties shown at the same rank)
- **Winner** (`$result->Winner`) and **Loser** (`$result->Loser`) for each selected method
- **Computation stats** (`$result->stats->asArray`) — detailed breakdown (pairwise matrix, round scores, etc.); collapsible panel per method

> **Implemented in:** `ElectionManager::computeResults()`
> **View:** `partials/results-method-detail.blade.php`
> **Implementation choice:** Stats are serialized via `serializeStats()` which accesses `$result->stats->asArray` inside a try/catch (some methods may return empty stats). Stats are displayed as a collapsible `<pre>` JSON block using `json_encode(..., JSON_PRETTY_PRINT)`.

### Global (Condorcet-specific)
- **Condorcet winner** (`$election->getCondorcetWinner()`) — displayed prominently; null if none exists
- **Condorcet loser** (`$election->getCondorcetLoser()`)

> **View:** `partials/results-display.blade.php` — shown as a green (winner) / red (loser) banner above the tabs

### Multi-method Comparison
- When multiple methods are selected, display results **side by side** (or stacked with clear separators)
- Highlight disagreements between methods — this is the core pedagogical value of the application

> **View:** `partials/results-overview.blade.php`
> **Implementation choice:** An overview table lists all selected methods with their winner, loser, and full ranking string. When winners disagree across methods, the table highlights discrepancies with amber styling and a pedagogical note explaining that different methods can produce different outcomes.

### Vote Visualization Tab
- The full vote list is displayed in a **Votes tab** within the results area (alongside Overview, Pairwise Matrix, and per-method tabs)
- The Votes tab is shown whenever there are votes, even if no results have been computed yet
- Table columns: vote index, full ranking (monospace), weight (if weight is allowed), quantity, remove button
- Summary header shows total vote entries and total weight

> **View:** `partials/votes-tab.blade.php`
> **Implementation choice:** The results area shows the tab bar whenever there are votes OR results. The default active tab is determined dynamically: `overview` → `pairwise` → `votes` (first available).

### Pairwise Matrix
- Always display the **pairwise comparison matrix** alongside results, regardless of selected methods
- The matrix is a grid where each cell shows the head-to-head result between two candidates: win/lose vote counts
- Data comes from `$election->getExplicitPairwise()` — see the library reference for the exact structure
- This is method-independent and central to understanding all Condorcet results

> **View:** `partials/pairwise-matrix.blade.php`
> **Implementation choice:** The matrix uses `win` and `opposition` keys from the pairwise data (not `win`/`lose`/`null`). Cells are color-coded green/red based on whether this candidate wins or loses the head-to-head matchup against each opponent.

### Empty State
- When there are fewer than 2 candidates or 0 votes, do not attempt computation
- Display a clear, friendly message explaining what is missing (e.g. "Add at least 2 candidates and 1 vote to compute results")
- The results area shows this state instead of an error or blank space

> **Implemented in:** `computeResults()` returns `['empty' => true, ...]` when preconditions fail
> **View:** `partials/results-display.blade.php` — shows an informational card with instructions

---

## 5. Import / Export

### Import
- **CondorcetElectionFormat (`.cvotes`)** — paste raw text directly into a textarea (no file upload)
- **Semicolon-separated candidates list** — direct textarea input

> **Implemented in:** `ElectionManager::importCvotes()`
> **View:** `partials/import-export.blade.php`
> **Implementation choice:** Uses `CondorcetElectionFormat::createFromString($text)->setDataToAnElection()`. After import, the component extracts candidates, votes, and configuration (`implicitRankingRule`, `authorizeVoteWeight`, `seatsToElect`) from the Election object and overwrites all local state. This means import is a full state replacement, not a merge.

### Export
- **Export election to `.cvotes` format** — the library supports this natively; allows users to save and share their election

> **Implemented in:** `ElectionManager::exportCvotes()`
> **View:** `partials/import-export.blade.php`
> **Implementation choice:** Uses `CondorcetElectionFormat::createFromElection($election)`. The output is displayed in a read-only textarea that the user can copy manually. Export requires at least 2 candidates.

---

## 6. Internationalisation (i18n)

- All user-facing strings are translated via Laravel's `__()` / `trans_choice()` helpers
a- **Supported languages:** English (default), French, Spanish, Portuguese, Italian, Polish, Czech, Russian, Arabic, Chinese, Hindi, Japanese, Esperanto, Bassa, Douala, Ghomálá'
- Language selector dropdown in the nav bar — pure Alpine.js, sets a `locale` cookie and reloads
- Locale detection priority: cookie (explicit user choice) → `Accept-Language` header (browser preference) → config default (`en`)
- Translation files live under `lang/{locale}/ui.php` — one file per locale, all keys in the `ui` namespace

> **Implemented in:** `App\Http\Middleware\SetLocale` (resolves locale from cookie, Accept-Language, or config default), `bootstrap/app.php` (registers middleware, excludes cookie from encryption)
> **Translation files:** `lang/en/ui.php` (canonical), plus 15 other locales in `lang/*/ui.php`
> **Config:** `config/locales.php` (single source of truth for supported locales)
> **View:** Language selector in `components/layouts/app.blade.php`
> **Tests:** `tests/Feature/SetLocaleTest.php` (cookie, Accept-Language, fallback, priority)
> **Implementation choice:** The `locale` cookie is set client-side and excluded from Laravel cookie encryption. The middleware resolves the locale using cookie → Accept-Language → config default. All Blade views use `__('ui.key')` and `trans_choice()`. Error messages in `ElectionManager.php` also use `__()` with `:message` placeholders. See [architecture.md](architecture.md#internationalisation-i18n) for details on adding new languages.
