# Condorcet PHP Library — Developer Reference

Library: `julien-boudry/condorcet ^5.0`  
Documentation: https://docs.condorcet.io/  
GitHub: https://github.com/julien-boudry/Condorcet

> Always use the official library documentation at https://docs.condorcet.io/ and the source code as the reference for the API. The examples below cover only the most common patterns — do not treat them as exhaustive.

---

## Core Workflow

```php
use CondorcetPHP\Condorcet\Election;

$election = new Election();

// Add candidates
$election->addCandidate('Alice');
$election->addCandidate('Bob');
$election->addCandidate('Charlie');

// Add votes (ranked ballots as strings)
$election->addVote('Alice > Bob > Charlie');
$election->addVote('Bob > Charlie > Alice');

// Get a result
$result = $election->getResult('Schulze');

// Condorcet winner/loser (may be null)
$winner = $election->getCondorcetWinner();
$loser  = $election->getCondorcetLoser();
```

---

## Election Configuration

```php
// Implicit ranking (default: true)
// When true, unranked candidates are treated as tied last.
// When false, they earn no points — changes results significantly.
$election->setImplicitRanking(false);

// Vote weight
$election->allowsVoteWeight(true);
$election->addVote('Alice > Bob', weight: 3);

// Vote constraints
use CondorcetPHP\Condorcet\Constraints\NoTie;
$election->addConstraint(NoTie::class);

// Number of seats (required for proportional methods)
$election->setNumberOfSeats(7);
```

---

## Getting Results

```php
// Full ranking
$result = $election->getResult('Schulze');

// Winner / Loser for a given method
$election->getWinner('Schulze');
$election->getLoser('Schulze');

// Condorcet winner / loser (independent of method)
$election->getCondorcetWinner(); // null if none
$election->getCondorcetLoser();  // null if none

// Computation stats
$result->getStats();

// Number of seats (proportional methods only)
$result->getNumberOfSeats();
```

---

## All Natively Supported Methods

### Single Winner Methods

| Method alias (for `getResult()`) | Notes |
|---|---|
| `Schulze` | Recommended variant (Winning). Also: `Schulze Margin`, `Schulze Ratio` |
| `Ranked Pairs Margin` | Also: `Ranked Pairs Winning` |
| `Borda Count` | Also: `Dowdall System` (Nauru variant) |
| `Copeland` | |
| `Instant-runoff` | Also known as IRV, AV, RCV |
| `Kemeny-Young` | Max 10 candidates by default |
| `FPTP` | First-past-the-post |
| `Multiple Rounds System` | Two-round system |
| `Minimax Winning` | Also: `Minimax Margin`, `Minimax Opposition` |
| `Dodgson Quick` | Also: `Dodgson Tideman` |
| `Random Ballot` | |
| `Random Candidates` | |

### Proportional Methods (require `setNumberOfSeats()`)

| Method alias | Type | Notes |
|---|---|---|
| `STV` | Individual | Single Transferable Vote; default quota: Droop |
| `CPO-STV` | Individual | CPO-STV; default quota: Hagenbach-Bischoff |
| `Sainte-Laguë` | Party | Webster method; supports Norwegian variant via `FirstDivisor` option |
| `Jefferson` | Party | D'Hondt method |
| `Largest Remainder` | Party | Default quota: Hare; supports Droop, Imperiali, Hagenbach-Bischoff |

### Informational Methods

| Method alias | Notes |
|---|---|
| `Smith set` | Smallest set beating all others; rank 1 = in set, rank 2 = outside |
| `Schwartz set` | Subset of Smith set; same ranking convention |

---

## Method Options

```php
// Borda Count: change starting point (default 1)
$election->setMethodOption('BordaCount', 'Starting', 0);

// Kemeny-Young: change max candidates (default 10)
use CondorcetPHP\Condorcet\Algo\Methods\KemenyYoung\KemenyYoung;
KemenyYoung::$MaxCandidates = 12; // or null for no limit

// STV / CPO-STV: change quota
use CondorcetPHP\Condorcet\Algo\Tools\StvQuotas;
$election->setMethodOption('STV', 'Quota', StvQuotas::HARE);
// Available: StvQuotas::DROOP, HARE, HAGENBACH_BISCHOFF, IMPERIALI

// Sainte-Laguë: Norwegian variant
$election->setMethodOption('SainteLague', 'FirstDivisor', 1.4);

// Largest Remainder: change quota
$election->setMethodOption('Largest Remainder', 'Quota', StvQuotas::DROOP);
```

---

## Pairwise Data

`$election->getExplicitPairwise()` returns the full head-to-head comparison matrix:

```php
// Structure: [candidateName => ['win' => [...], 'lose' => [...], 'null' => [...]]]
$pairwise = $election->getExplicitPairwise();

// Example: how many votes ranked Alice above Bob
$pairwise['Alice']['win']['Bob'];  // votes where Alice beats Bob
$pairwise['Alice']['lose']['Bob']; // votes where Bob beats Alice
$pairwise['Alice']['null']['Bob']; // ties between Alice and Bob
```

This matrix is method-independent and should be displayed as a grid/table (rows = candidates, columns = opponents), showing win/lose/tie counts for every pair.

---

## Import / Export (CondorcetElectionFormat)

Spec: https://github.com/CondorcetVote/CondorcetElectionFormat

### Format Example

```
# My election
#/Candidates: Alice ; Bob ; Charlie
#/Number of Seats: 7
#/Implicit Ranking: true
#/Weight Allowed: false

# Votes
Alice > Bob > Charlie * 42
Bob > Alice = Charlie
Charlie > Alice
```

### Parameters (all optional)

| Parameter | Format | Default |
|---|---|---|
| `#/Candidates:` | Names separated by `;` | parsed from votes |
| `#/Number of Seats:` | integer | 100 |
| `#/Implicit Ranking:` | `true` / `false` | `true` |
| `#/Weight Allowed:` | `true` / `false` | `false` |
| `#/Voting Methods:` | Method names separated by `;` | none |

### Vote Line Format

```
(tags ||) Ranking (^weight) (* quantifier)
```

- `>` separates ranks. `=` denotes a tie within a rank.
- `*` is a **quantifier** (N identical votes). `^` is a **weight** (vote importance).
- `/EMPTY_RANKING/` is a blank ballot.
- `#` starts a comment (not allowed on parameter lines).
- Reserved characters: `> = ; , # / * ^`

### PHP Usage

```php
use CondorcetPHP\Condorcet\Tools\Converters\CondorcetElectionFormat;

// Import from raw .cvotes string (no file needed)
$parser = new CondorcetElectionFormat($cvotesString);
$election = $parser->setUpElection();

// Export to .cvotes string
$output = CondorcetElectionFormat::exportElectionToString($election);
```

---

## Stats Verbosity (Kemeny-Young, CPO-STV)

```php
use CondorcetPHP\Condorcet\Algo\StatsVerbosity;

$election->setStatsVerbosity(StatsVerbosity::FULL);
$election->getResult('Kemeny-Young')->getStats();
// Warning: FULL stats can be slow/memory-heavy for large elections
```
