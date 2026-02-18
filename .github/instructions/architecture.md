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
