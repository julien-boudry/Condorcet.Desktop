# Architecture & Technical Stack

## Overview

**Condorcet Desktop** is a Laravel application packaged as a NativePHP desktop app, but must work equally well as a plain web application. The server is fully stateless — it stores nothing and only serves rendered pages and election computations.

---

## Stateless Server

- No server-side database. No session storage. The server is deployment-agnostic.
- Every request must be self-contained: the client sends the full election state, the server recomputes, and returns a fully rendered response.

---

## `localStorage` — One Purpose Only

`localStorage` has **one single purpose**: persisting the election state so it can be **resubmitted in full** to the server whenever the user makes any change.

- **Never used for display.** The server always returns a fully rendered page section (via Livewire). The client never constructs or patches the UI from stored data.
- On every user action (add a vote, remove a candidate, toggle a method…), the full current state is read from `localStorage`, sent to the server, which recomputes everything and returns the complete rendered result.

### `localStorage` JSON Schema

The state is serialized as a single JSON object. This is also the exact payload sent to the server:

```json
{
  "candidates": ["Alice", "Bob", "Charlie"],
  "votes": [
    { "ranking": "Alice > Bob > Charlie", "weight": 1, "quantity": 1 },
    { "ranking": "Bob > Alice", "weight": 1, "quantity": 3 }
  ],
  "methods": ["Schulze", "Borda Count"],
  "seats": 7,
  "implicitRanking": true,
  "weightAllowed": false
}
```

The server deserializes this payload and reconstructs the `Election` object from scratch on every request.

> If the schema changes during development, keep this documentation in sync. The key used in `localStorage` for the election state is `electionState`. The dark mode preference uses a separate key `colorScheme`. These must never collide.

---

## Technology Stack

| Layer | Tool | Notes |
|---|---|---|
| Templating | Blade | Prefer plain components over complex abstractions |
| Reactivity | Livewire 4 | For all server round-trips |
| Styling | Tailwind CSS v4 | No custom CSS unless unavoidable |
| Client interactions | Alpine.js | Bundled with Livewire; use only when no server round-trip is needed |
| Asset bundler | Vite + Bun | Use `bun run dev` / `bun run build`; never npm |
| Desktop packaging | NativePHP | Must also work as a standard web app |

### JavaScript Policy

**Minimize JavaScript to the absolute minimum.** The order of preference is:

1. **Livewire** (server-side logic) — always the first choice
2. **Alpine.js** — for purely client-side interactions with no need for a server round-trip
3. **Raw JS** — only as a last resort when neither Livewire nor Alpine can do it

Never write raw JavaScript unless there is truly no other way.

**No Vue, React, Inertia, or any other JS framework.**  
**No API routes** unless strictly necessary.  
**No new Composer/Bun dependencies** without explicit user approval.

---

## Application Structure — Single Page

The app is a **single page**. On first load, the full page is server-rendered. Subsequent interactions use Livewire to replace only the central results section — no full page reload.

### Page Layout

- **Left/top panel** — election setup form (candidates, votes, configuration, method selection). Always visible. State is persisted to `localStorage` on every change.
- **Central results section** — server-rendered by Livewire on each submission. Contains all results, stats, and the Condorcet winner/loser for all selected methods at once.
- **Tab navigation (client-side)** — after the server responds with the full results block, tabs allow browsing between methods, stats panels, and comparison views **without further server calls**. Tabs are pure Alpine.js.

### Error & Warning Handling

- If the server encounters a **warning** (e.g. Kemeny-Young with too many candidates, invalid vote format), display the warning message inline and restore the form to its last valid input state. Do not clear the form.
- **Hard errors** (e.g. malformed input that cannot be parsed) are shown as validation errors near the relevant input field.

---

## NativePHP Compatibility

- Do not use features that only work in one environment (desktop or web). When in doubt, use the web-compatible path.
- Do not rely on filesystem persistence for user data — use `localStorage` on the client side.

---

## Implementation Notes

> This section documents the architectural choices made during the initial implementation. Keep it in sync as the codebase evolves.

### Single Livewire Component

The entire application lives in **one full-page Livewire component**: `App\Livewire\ElectionManager`. It is mounted directly as a route in `routes/web.php`:

```php
Route::get('/', ElectionManager::class)->name('home');
```

There are no controllers. The component uses the `#[Layout('components.layouts.app')]` attribute to specify the Blade layout.

**Rationale:** The spec mandates a single-page application with one results section updated by Livewire. A single component keeps all election state co-located and avoids cross-component communication complexity.

### File Structure

```
app/Livewire/ElectionManager.php          — All server-side logic (685 lines)
resources/views/components/layouts/app.blade.php  — HTML shell, nav bar, dark mode toggle
resources/views/livewire/election-manager.blade.php — Main view (sidebar + results + @script)
resources/views/livewire/partials/
    candidate-panel.blade.php     — Add/remove candidates (single + bulk)
    vote-panel.blade.php          — Add/remove votes (ranking, weight, quantity)
    config-panel.blade.php        — Implicit ranking, weight, NoTie, seats
    method-selector.blade.php     — Method checkboxes grouped by family + per-method options
    import-export.blade.php       — .cvotes import/export textareas + reset button
    results-display.blade.php     — Tab shell (overview, per-method, pairwise) + empty state
    results-overview.blade.php    — Cross-method comparison table with disagreement highlighting
    results-method-detail.blade.php — Per-method card (ranking, winner/loser, collapsible stats)
    pairwise-matrix.blade.php     — Head-to-head grid with color-coded cells
```

### Stateless Recomputation Pattern

The `render()` method calls `computeResults()` on every Livewire render cycle. `computeResults()` internally calls `buildElection()`, which creates a **fresh** `Election` object from the public properties every time. No election state is cached between requests.

```
User action → Livewire re-render → render() → computeResults() → buildElection() → fresh Election
```

This is intentional: the Condorcet library objects are not serializable, and the server must remain stateless. The performance cost is negligible for the expected data volumes (dozens of candidates, hundreds of votes).

### localStorage Sync Mechanism

State flows between client and server through a **two-step handshake**:

1. **Client → Server (on mount):** The `@script` block reads `localStorage.getItem('electionState')`, parses it, and calls `$wire.loadFromLocalStorage(state)` to hydrate the component.

2. **Server → Client (on every mutation):** Every action method (`addCandidate`, `addVote`, `toggleMethod`, etc.) ends with `$this->syncState()`, which dispatches a `election-state-updated` Livewire event. The `@script` listener writes the payload to `localStorage`.

The `loadFromLocalStorage()` method is the **only** way state enters the component from previous sessions. The `syncState()` method defines the **canonical** shape of the persisted JSON — if you add new persisted fields, update both methods.

### Tab Navigation (Alpine.js)

Results tabs (Overview, per-method tabs, Pairwise) are managed entirely client-side with Alpine's `x-data`, `x-show`, and `x-cloak`. No server round-trip when switching tabs — the full results block is already rendered and hidden tabs are toggled with CSS.

### Dark Mode

Class-based strategy using `@variant dark (&:where(.dark, .dark *))` in CSS. A small inline `<script>` in the layout reads `localStorage.getItem('colorScheme')` **before** first paint to prevent flash. The toggle button in the nav bar uses Alpine to add/remove the `.dark` class and persist to `localStorage`.

### Per-Method Options

Method-specific settings (Borda starting point, Kemeny max candidates, STV/CPO-STV quotas, Sainte-Laguë divisor, Largest Remainder quota) are stored as public Livewire properties. They are applied in `applyMethodOptions()` before vote parsing. The `method-selector` partial conditionally shows the option controls only when the relevant method is selected.

### Warnings vs. Errors

- **Validation errors** (`$this->addError(...)`) are used for form input problems (empty candidate name, duplicate, empty vote ranking, bad import text). They display near the relevant input via Livewire's `@error` directive.
- **Warnings** (`$this->warnings[]`) are used for non-fatal computation issues (vote parsing errors, pairwise errors). They display in a banner above the results area.

### Testing

All tests are in `tests/Feature/ElectionManagerTest.php` using Pest + Livewire's testing API. Tests cover: page rendering, candidate management, vote management, method toggling, configuration changes, results computation, import/export, localStorage loading, reset, and event dispatching. Run with:

```bash
php artisan test --compact
```
