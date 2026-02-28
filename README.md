<p align="center">
  <img src="public/images/condorcet-logo.avif" alt="Condorcet Logo" width="120">
</p>

<h1 align="center">Condorcet Desktop</h1>

<p align="center">
  <strong>A powerful GUI to explore ranked-choice voting methods</strong><br>
  Powered by the <a href="https://github.com/julien-boudry/Condorcet">Condorcet PHP</a> library
</p>

<p align="center">
  <a href="https://desktop.condorcet.vote"><img src="https://img.shields.io/badge/Live_Demo-desktop.condorcet.vote-2ea44f?style=for-the-badge" alt="Live Demo"></a>
  <a href="https://github.com/julien-boudry/Condorcet"><img src="https://img.shields.io/badge/Condorcet_PHP-Library-blue?style=for-the-badge" alt="Condorcet PHP Library"></a>
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT License"></a>
</p>

---

## About

**Condorcet Desktop** is a fully interactive application for creating elections, adding candidates and votes, and computing results using dozens of voting methods — all through an intuitive graphical interface.

It is built on top of the [**Condorcet PHP**](https://github.com/julien-boudry/Condorcet) library (`julien-boudry/condorcet ^5.0`), by the same author. Condorcet PHP is a comprehensive, high-performance library implementing a wide range of ranked-choice and proportional voting methods. This application serves as a graphical showcase for most of its features.

> **Try it now** — a live demo is available at **[desktop.condorcet.vote](https://desktop.condorcet.vote)**

### Coming Soon: Desktop & Mobile

A fully local desktop and mobile version — powered by [NativePHP](https://nativephp.com) — is on the way. Run elections entirely offline, with zero server dependency.

---

## Features

### Election Setup
- Add candidates one by one or in bulk (`;` separated)
- Add votes using the intuitive Condorcet ranking syntax (`Alice > Bob = Charlie`)
- Bulk vote import with support for weights (`^3`) and quantities (`* 5`)
- Full [CondorcetElectionFormat (`.cvotes`)](https://docs.condorcet.io/) import & export

### Voting Methods
Over **30 voting methods** grouped by family:

| Family | Methods |
|---|---|
| **Single-winner** | Schulze (Winning / Margin / Ratio), Ranked Pairs (Margin / Winning), Borda Count, Dowdall, Copeland, Instant-Runoff, Kemeny–Young, FPTP, Multiple Rounds, Minimax (Winning / Margin / Opposition), Dodgson (Quick / Tideman), Random Ballot, Random Candidates |
| **Proportional** | STV, CPO-STV, Sainte-Laguë, D'Hondt (Jefferson), Largest Remainder (Hare / Droop / Imperiali / Hagenbach-Bischoff) |
| **Informational** | Smith set, Schwartz set |

Select one or many methods simultaneously and compare results side by side. The app highlights disagreements between methods — the core pedagogical value of the Condorcet approach.

### Per-Method Options
Fine-tune method behavior directly from the UI:
- **Borda Count** — starting point (0 or 1)
- **Kemeny–Young** — max candidates limit
- **STV / CPO-STV / Largest Remainder** — quota choice (Droop, Hare, Hagenbach-Bischoff, Imperiali)
- **Sainte-Laguë** — first divisor (standard, Norwegian variant, etc.)

### Results & Analysis
- Full ranking with tie display
- Condorcet winner & loser detection
- Pairwise comparison matrix (color-coded)
- Detailed computation stats per method
- Multi-method comparison table with disagreement highlighting

### Configuration
- Implicit vs. explicit ranking mode
- Vote weight support
- NoTie constraint
- Configurable number of seats for proportional methods

### Internationalization
Available in **16 languages**: English, French, Spanish, Portuguese, Italian, Polish, Czech, Russian, Arabic, Chinese, Hindi, Japanese, Esperanto, Ɓasaá, Duálá, Ghomálá'. Automatic language detection from browser preferences.

### Dark Mode
Full dark mode support with persistent preference.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 / PHP 8.5+ |
| Reactivity | Livewire 4 |
| Styling | Tailwind CSS v4 |
| Client interactions | Alpine.js |
| Voting engine | [Condorcet PHP ^5.0](https://github.com/julien-boudry/Condorcet) |
| Desktop packaging | NativePHP *(coming soon)* |
| Production server | FrankenPHP + Laravel Octane |
| Asset bundler | Vite + Bun |

---

## Getting Started

### Prerequisites

- PHP 8.5+
- Composer 2.x
- [Bun](https://bun.sh)

### Installation

```bash
git clone https://github.com/julien-boudry/Condorcet.Desktop.git
cd Condorcet.Desktop
composer setup
```

The `composer setup` script handles everything: installs dependencies, creates the `.env` file, generates the app key, runs migrations, and builds frontend assets.

### Development

```bash
composer run dev
```

This starts the development server, queue worker, log viewer, and Vite dev server concurrently.

### Running Tests

```bash
php artisan test
```

### Production Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for a complete guide on deploying with FrankenPHP + Laravel Octane.

---

## The Condorcet PHP Library

This application is powered by [**Condorcet PHP**](https://github.com/julien-boudry/Condorcet), a standalone PHP library for ranked-choice voting, by the same author. The library provides:

- **30+ voting methods** — from Schulze and Ranked Pairs to STV and D'Hondt
- **High performance** — optimized for large elections with thousands of votes
- **Full pairwise computation** — the foundation of all Condorcet-family methods
- **CondorcetElectionFormat** — a portable text format for elections
- **No dependencies** — pure PHP, usable in any project

If you need voting method computation in your own PHP project, use the library directly:

```bash
composer require julien-boudry/condorcet
```

📖 **Documentation:** [docs.condorcet.io](https://docs.condorcet.io)

---

## License

This project is open-sourced under the [MIT License](LICENSE).

---

<p align="center">
  Made with ❤️ by <a href="https://github.com/julien-boudry">Julien Boudry</a>
</p>
