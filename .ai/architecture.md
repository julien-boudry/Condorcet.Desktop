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
  "methods": ["Schulze Winning", "Borda Count"],
  "seats": 7,
  "implicitRanking": true,
  "weightAllowed": false
}
```

The server deserializes this payload and reconstructs the `Election` object from scratch on every request.

> If the schema changes during development, keep this documentation in sync. The key used in `localStorage` for the election state is `electionState`. The dark mode preference uses a separate key `colorScheme`. The UI language preference uses a `locale` cookie (not `localStorage`). These must never collide.

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
app/Http/Middleware/SetLocale.php          — Reads locale cookie, sets app locale
app/Livewire/ElectionManager.php          — All server-side logic (765 lines)
lang/en/ui.php                            — English UI translations (canonical)
lang/fr/ui.php                            — French UI translations
lang/zh/ui.php                            — Chinese (Simplified) UI translations
lang/ja/ui.php                            — Japanese UI translations
lang/eo/ui.php                            — Esperanto UI translations
lang/it/ui.php                            — Italian UI translations
lang/hi/ui.php                            — Hindi UI translations
resources/views/components/layouts/app.blade.php  — HTML shell, nav bar, dark mode toggle, language selector
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

### Livewire Request / Response Cycle

Every user interaction (add candidate, toggle method, etc.) triggers a `POST /livewire/update` request. The server stores **nothing** between requests — the full component state travels with every request:

```
[Browser]                                    [Server]
    │                                            │
    │── POST /livewire/update ──────────────────►│
    │   {                                        │
    │     snapshot: { data: {candidates, votes,  │
    │       methods, seats, ...}, memo: {...} }, │
    │     checksum: "HMAC-SHA256(...)",           │
    │     updates: [{ type: "callMethod",        │
    │       payload: { method: "addVote" } }]    │
    │   }                                        │
    │                                            │
    │                          1. Verify HMAC checksum
    │                          2. Deserialize snapshot
    │                             → ElectionManager object
    │                          3. Apply updates (addVote())
    │                             → syncState() dispatches event
    │                          4. render() → computeResults()
    │                             → buildElection() → fresh Election
    │                          5. Diff HTML output
    │                          6. Serialize new snapshot + sign
    │                                            │
    │◄── Response ──────────────────────────────│
    │   {                                        │
    │     snapshot: { ...updated state... },     │
    │     checksum: "new HMAC-SHA256(...)",       │
    │     effects: {                             │
    │       html: "...morphable diff...",         │
    │       dispatches: [{                       │
    │         name: "election-state-updated",    │
    │         data: { state: {...} }             │
    │       }]                                   │
    │     }                                      │
    │   }                                        │
    │                                            │
    │ 1. Morph DOM with new HTML (Alpine morph)  │
    │ 2. Fire dispatched events → @script        │
    │    listener → localStorage.setItem(...)    │
    │ 3. Store new snapshot+checksum in JS       │
    │    memory for next request                 │
```

**Snapshot:** A JSON serialization of all public properties of the Livewire component. It represents the complete server-side state and is generated by the server on every response.

**HMAC checksum:** The snapshot is signed with `HMAC-SHA256(snapshot, APP_KEY)`. The `APP_KEY` (from `.env`) is only known to the server. On every incoming request, the server recalculates the HMAC and rejects the request (403) if it doesn't match — this prevents clients from tampering with the state (e.g. injecting fake candidates or votes). Note: the `updates` array (method calls) is **not** signed, but Livewire only allows calling public methods on the component.

**Effects:** The response includes only the HTML fragments that changed (morphed into the DOM) and any dispatched events. This is how `syncState()` reaches the `@script` listener to persist to `localStorage`.

### localStorage Sync Mechanism

State flows between client and server through a **two-step handshake**:

1. **Client → Server (on mount):** The `@script` block reads `localStorage.getItem('electionState')`, parses it, and calls `$wire.loadFromLocalStorage(state)` to hydrate the component.

2. **Server → Client (on every mutation):** Every action method (`addCandidate`, `addVote`, `toggleMethod`, etc.) ends with `$this->syncState()`, which dispatches a `election-state-updated` Livewire event. The `@script` listener writes the payload to `localStorage`.

The `loadFromLocalStorage()` method is the **only** way state enters the component from previous sessions. The `syncState()` method defines the **canonical** shape of the persisted JSON — if you add new persisted fields, update both methods.

**Two distinct storages exist concurrently:**
- **Livewire snapshot** (JS memory) — used by Livewire for the next request; lost on page refresh
- **`localStorage`** (persistent) — used only on page load to restore state via `loadFromLocalStorage()`

### Tab Navigation (Alpine.js)

Results tabs (Overview, per-method tabs, Pairwise) are managed entirely client-side with Alpine's `x-data`, `x-show`, and `x-cloak`. No server round-trip when switching tabs — the full results block is already rendered and hidden tabs are toggled with CSS.

### Dark Mode

Class-based strategy using `@variant dark (&:where(.dark, .dark *))` in CSS. A small inline `<script>` in the layout reads `localStorage.getItem('colorScheme')` **before** first paint to prevent flash. The toggle button in the nav bar uses Alpine to add/remove the `.dark` class and persist to `localStorage`.

### Internationalisation (i18n)

The app uses **Laravel's built-in translation system** (`__()` / `trans_choice()`). All user-facing strings are extracted into PHP translation files under `lang/{locale}/ui.php`.

**Supported locales:** `en` (default), `fr`, `zh`, `ja`, `eo`, `it`, `hi`.

**File structure:**
```
lang/
    en/ui.php   — English strings (canonical reference)
    fr/ui.php   — French translation
    zh/ui.php   — Chinese (Simplified) translation
    ja/ui.php   — Japanese translation
    eo/ui.php   — Esperanto translation
    it/ui.php   — Italian translation
    hi/ui.php   — Hindi translation
```

**Locale detection:**
- A lightweight middleware (`App\Http\Middleware\SetLocale`) reads the `locale` cookie on every request and calls `app()->setLocale()`.
- The `locale` cookie is excluded from Laravel's cookie encryption so that client-side JavaScript can read/write it.
- The language selector in the nav bar is a dropdown menu (Alpine.js) that sets the cookie and reloads the page — no Livewire round-trip needed for locale changes.
- English is always the default. Browser language is never auto-detected.

**Adding a new language:**
1. Copy `lang/en/ui.php` to `lang/{locale}/ui.php` and translate all values.
2. Add the locale to the `SUPPORTED` array in `SetLocale` middleware.
3. Add the locale and its native label to the `$locales` map in the dropdown in `app.blade.php`.

**Key conventions:**
- All translation keys live in the `ui` namespace (single file per locale).
- Keys are grouped by view/section with descriptive prefixes.
- Strings containing HTML use `{!! __('ui.key') !!}` (raw output).
- Pluralised strings use `trans_choice('ui.key', $count)` with pipe-separated forms.
- Error/warning messages in `ElectionManager.php` also use `__()` with `:message` placeholders.

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
