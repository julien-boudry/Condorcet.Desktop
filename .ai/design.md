# Design Guidelines

> **Implementation status:** All guidelines below are implemented as specified. Notes on implementation choices are added in blockquotes.

## Brand Identity

### Logo
Use the official Condorcet logo (without text) available at:  
`https://docs.condorcet.io/condorcet-logo-without-text.avif`

Download and store it locally at `public/images/condorcet-logo.avif`.

> **Implemented.** The logo is downloaded and served locally. It is used in the nav bar (`<img class="h-8 w-8">`) and as the favicon (`<link rel="icon">`).

### Brand Color
The primary brand color is **Condorcet Orange: `#f57255`**.

Register it as a custom Tailwind color in `resources/css/app.css`:

```css
@import "tailwindcss";

@theme {
  --color-brand: #f57255;
  --color-brand-dark: #d4593a;
  --color-brand-light: #f89a82;
}
```

Use `bg-brand`, `text-brand`, `border-brand`, `hover:bg-brand-dark` etc. throughout.

> **Implemented.** All three brand color variants are registered in `resources/css/app.css` under `@theme`. Used for primary buttons, active tabs, and accent highlights throughout the UI.

---

## Design Principles

- **Sober and readable.** Clean layout, generous whitespace, clear typographic hierarchy.
- **Colorful but not loud.** The orange is used for primary actions, active states, and key highlights — not as a background for large areas.
- **Data-dense but not cluttered.** The results section must present complex ranked data (tables, scores, stats) clearly. Use borders, spacing, and color to separate concerns without visual noise.

---

## Dark Mode

Dark mode is supported via Tailwind's `dark:` variant, using the **class strategy** (a `.dark` class on `<html>`).

### Tailwind Configuration

In `resources/css/app.css`, ensure the dark mode variant is class-based:

```css
@import "tailwindcss";

@variant dark (&:where(.dark, .dark *));
```

### Dark Mode Switcher

A toggle button (sun/moon icon) is placed in the top navigation bar. It persists the user's preference to `localStorage` under the key `colorScheme`. Follow Tailwind CSS v4 best practices for the class-based dark mode strategy — consult `search-docs` for the current recommended approach before implementing.

> **Implemented in:** `resources/views/components/layouts/app.blade.php`  
> **Implementation choice:** The toggle uses Alpine.js to add/remove the `.dark` class on `<html>` and persist to `localStorage`. A small inline `<script>` in `<head>` (before Vite assets) reads the preference and applies the class before first paint, preventing a flash of wrong theme. Uses SVG sun/moon icons that swap based on `.dark` state.

### Color Palette Convention

| Role | Light | Dark |
|---|---|---|
| Page background | `bg-white` / `bg-gray-50` | `dark:bg-gray-950` |
| Card / panel background | `bg-white` | `dark:bg-gray-900` |
| Border | `border-gray-200` | `dark:border-gray-700` |
| Primary text | `text-gray-900` | `dark:text-gray-100` |
| Secondary text | `text-gray-500` | `dark:text-gray-400` |
| Brand accent | `text-brand` / `bg-brand` | same (orange works on dark backgrounds) |
| Input background | `bg-white` | `dark:bg-gray-800` |
| Input border | `border-gray-300` | `dark:border-gray-600` |

---

## Typography

- Use the system font stack (Tailwind's `font-sans`).
- Section headings: `text-xl font-semibold` or `text-lg font-semibold`
- Labels: `text-sm font-medium text-gray-700 dark:text-gray-300`
- Code / vote strings (rankings): `font-mono text-sm`

> **Implemented.** The default font is overridden in `resources/css/app.css` via `--font-sans` to use the standard system font stack (the Laravel default `Instrument Sans` was removed). Vote ranking inputs use `font-mono` for clarity.

---

## Layout

- Single-page layout with a **top navigation bar** (logo + app name + dark mode toggle).
- Below: a two-column layout on wide screens — **left sidebar** for election setup inputs, **right/center main area** for results.
- On narrow screens (mobile or small NativePHP window): stacked single column.
- Use Tailwind's responsive prefixes (`md:`, `lg:`) for breakpoints.

> **Implemented in:** `resources/views/components/layouts/app.blade.php` (nav bar) and `resources/views/livewire/election-manager.blade.php` (two-column layout)  
> **Implementation choice:** The sidebar uses `lg:w-96 shrink-0` and the results area uses `flex-1 min-w-0`. Below `lg:` breakpoint, both stack vertically. The nav bar is `sticky top-0 z-50` for persistent access to the dark mode toggle.

---

## Component Conventions

- **Primary buttons**: `bg-brand hover:bg-brand-dark text-white font-medium rounded-lg px-4 py-2`
- **Secondary / ghost buttons**: `border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800`
- **Danger buttons** (delete candidate, remove vote): `text-red-600 hover:text-red-800 dark:text-red-400`
- **Tabs** (results navigation): active tab uses `border-b-2 border-brand text-brand`, inactive uses `text-gray-500 dark:text-gray-400 hover:text-gray-700`
- **Warning banners**: `bg-amber-50 dark:bg-amber-900/20 border border-amber-300 dark:border-amber-700 text-amber-800 dark:text-amber-300`
- **Result rank rows**: alternate row shading with `even:bg-gray-50 dark:even:bg-gray-800/50` for readability

> **All implemented as specified.** Warning banners appear in two contexts: the warnings area above results (for computation warnings) and the disagreement highlight in the overview table (for pedagogical notes about method disagreements).

---

## Reuse Notes

When adding new UI elements, follow these conventions:

- **Sidebar panels** use the pattern: `<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">` with an `<h2 class="text-lg font-semibold ...">` heading.
- **Inputs** use: `border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-brand focus:border-brand`.
- **Result cards** use the same panel pattern as sidebar panels.
- **Lists with remove buttons** use `<ul class="space-y-1">` with each `<li>` showing the item text and a red × button aligned right.
- **Checkboxes** use `rounded border-gray-300 dark:border-gray-600 text-brand focus:ring-brand` with a `<label>` wrapper.
- **Empty states** use a centered card with a muted icon, heading, and descriptive text.
