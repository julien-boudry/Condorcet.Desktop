# Feature Specifications

## 1. Election Setup

### Candidates
- Add candidates via a **form** (one by one, fluid UX with minimal JS)
- **OR** paste a **semicolon-separated list** (e.g. `Alice;Bob;Charlie`) — the library parses this natively
- Display current candidates list; allow removing individual candidates

### Votes
- Add votes **one by one** via a ranked-ballot form (format: `Alice > Bob > Charlie`, ties: `Alice = Bob > Charlie`)
- **OR** paste raw **CondorcetElectionFormat (`.cvotes`)** text — see the format reference in [condorcet-library.md](condorcet-library.md)
- Display current vote list; allow removing individual votes

---

## 2. Election Configuration

### General Options
- **Implicit vs. explicit ranking mode** (`setImplicitRanking(bool)`) — affects how unranked candidates are treated; pedagogically important, should be clearly explained in the UI
- **Vote weight** — allow setting a weight on individual votes; demonstrate its effect on results
- **Vote constraints** — at minimum expose the `NoTie` constraint (recommended by the library for several proportional methods)

### Proportional Mode
- **Number of seats** (`setNumberOfSeats(int)`) — required for all proportional methods (STV, D'Hondt, Sainte-Laguë, LR families)
- When a proportional method is selected, show the seats configuration prominently

---

## 3. Voting Methods Selection

- Allow selecting **one or multiple voting methods simultaneously**
- Methods are grouped by family:
  - **Single winner**: Schulze (Winning/Margin/Ratio), Ranked Pairs (Margin/Winning), Borda Count, Dowdall, Copeland, Instant-runoff, Kemeny-Young, FPTP, Multiple Rounds, Minimax (Winning/Margin/Opposition), Dodgson (Quick/Tideman), Random Ballot, Random Candidates
  - **Proportional**: STV, CPO-STV, Sainte-Laguë, D'Hondt (Jefferson), Largest Remainder (Hare/Droop/Imperiali/Hagenbach-Bischoff)
  - **Informational**: Smith set, Schwartz set

### Per-Method Options
Expose relevant method options via the UI:
- **Borda Count** — starting point (default 1, can be set to 0)
- **Kemeny-Young** — maximum candidates limit (default 10, configurable, or null for no limit)
- **STV / CPO-STV** — quota choice (Droop, Hare, Hagenbach-Bischoff, Imperiali)
- **Sainte-Laguë** — first divisor (1 = standard, 1.4 = Norwegian variant, etc.)

---

## 4. Results Display

### Per Method
- **Full ranking** — complete ordered list (with ties shown at the same rank)
- **Winner** (`getWinner()`) and **Loser** (`getLoser()`) for each selected method
- **Computation stats** (`$result->getStats()`) — detailed breakdown (pairwise matrix, round scores, etc.); collapsible panel per method

### Global (Condorcet-specific)
- **Condorcet winner** (`$election->getCondorcetWinner()`) — displayed prominently; null if none exists
- **Condorcet loser** (`$election->getCondorcetLoser()`)

### Multi-method Comparison
- When multiple methods are selected, display results **side by side** (or stacked with clear separators)
- Highlight disagreements between methods — this is the core pedagogical value of the application

### Pairwise Matrix
- Always display the **pairwise comparison matrix** alongside results, regardless of selected methods
- The matrix is a grid where each cell shows the head-to-head result between two candidates: win/lose/tie vote counts
- Data comes from `$election->getExplicitPairwise()` — see the library reference for the exact structure
- This is method-independent and central to understanding all Condorcet results

### Empty State
- When there are fewer than 2 candidates or 0 votes, do not attempt computation
- Display a clear, friendly message explaining what is missing (e.g. "Add at least 2 candidates and 1 vote to compute results")
- The results area shows this state instead of an error or blank space

---

## 5. Import / Export

### Import
- **CondorcetElectionFormat (`.cvotes`)** — paste raw text directly into a textarea (no file upload)
- **Semicolon-separated candidates list** — direct textarea input

### Export
- **Export election to `.cvotes` format** — the library supports this natively; allows users to save and share their election
