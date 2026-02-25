# Web Production Deployment Guide

> **Keep this document up to date.** Whenever the deployment process, environment
> variables, dependencies, or infrastructure requirements change, update this file
> accordingly.

This guide covers deploying **Condorcet.Desktop** as a production web application
served by **FrankenPHP** with **Laravel Octane**.

---

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Environment Configuration](#environment-configuration)
3. [Build Frontend Assets](#build-frontend-assets)
4. [Composer Production Install](#composer-production-install)
5. [Database & Migrations](#database--migrations)
6. [Laravel Caches](#laravel-caches)
7. [Sessions](#sessions)
8. [Running with FrankenPHP + Octane](#running-with-frankenphp--octane)
9. [Health Check](#health-check)
10. [Full Deployment Script](#full-deployment-script)
11. [Octane Compatibility Notes](#octane-compatibility-notes)
12. [Optional Enhancements](#optional-enhancements)

---

## Prerequisites

- **PHP 8.5+** with required extensions (mbstring, openssl, tokenizer, etc.)
- **FrankenPHP** installed (standalone binary or Docker image)
- **Bun** (for building frontend assets)
- **Composer 2.x**
- **Laravel Octane** with the FrankenPHP driver — already installed and configured
  (`config/octane.php` is committed to the repository)

---

## Environment Configuration

Create the `.env` file from the example and adjust for production:

```bash
cp .env.example .env
php artisan key:generate --force
```

**Required production values:**

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# Stateless session — CSRF token lives in an encrypted cookie,
# no server-side session storage needed.
SESSION_DRIVER=cookie

# Cache driver — "file" for single-server, "redis" for multi-server.
CACHE_STORE=file

# Queue — not used by the app, but set to "sync" to avoid
# needing a queue worker.
QUEUE_CONNECTION=sync

# Database — only needed for migrations (cache/sessions tables).
# With cookie sessions and file cache, SQLite is not required at all.
# Keep it if you want the /up health check to verify DB connectivity.
DB_CONNECTION=sqlite
```

---

## Build Frontend Assets

Vite produces fingerprinted, minified CSS and JS bundles:

```bash
bun install
bun run build
```

The compiled assets land in `public/build/` with a `manifest.json` that Laravel
reads at runtime. **Do not** run `bun run dev` in production.

---

## Composer Production Install

```bash
composer install --no-dev --optimize-autoloader --no-interaction
```

This excludes dev dependencies (Pest, Pint, Pail, Boost, etc.) and generates
an optimized class map for faster autoloading.

---

## Database & Migrations

With `SESSION_DRIVER=cookie` and `CACHE_STORE=file`, the app does **not need a
database at all**. The server is fully stateless.

If you keep `DB_CONNECTION=sqlite` (e.g. for the `/up` health check or future
features), run migrations:

```bash
php artisan migrate --force
```

Otherwise, you can safely remove the SQLite file and skip migrations entirely.

---

## Laravel Caches

These commands pre-compile configuration, routes, views, and events into cached
files for faster boot times. **Essential for Octane** since the worker boots
once and serves all requests from memory.

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

To clear all caches (e.g. during a redeployment):

```bash
php artisan optimize:clear
```

---

## Sessions

**This app cannot fully disable sessions.** Livewire requires a CSRF token
(stored in the session) for every `POST /livewire/update` request, and the
`WithFileUploads` trait stores temporary file references in the session.

The recommended driver is **`cookie`**:

- Zero server-side storage — fully aligns with the stateless architecture.
- The CSRF token and minimal Livewire data live in an encrypted cookie.
- No database, no files, no Redis needed for sessions.

```dotenv
SESSION_DRIVER=cookie
```

---

## Running with FrankenPHP + Octane

### Direct (binary)

```bash
php artisan octane:start --server=frankenphp --host=0.0.0.0 --port=8000 --workers=auto
```

- `--workers=auto` lets Octane auto-detect the optimal worker count based on
  CPU cores.
- Add `--max-requests=1000` to recycle workers and prevent potential memory
  leaks from the Condorcet library's heavy computations.

### With a Process Manager (systemd example)

```ini
[Unit]
Description=Condorcet Octane (FrankenPHP)
After=network.target

[Service]
User=www-data
WorkingDirectory=/var/www/condorcet
ExecStart=/usr/bin/php artisan octane:start --server=frankenphp --host=0.0.0.0 --port=8000 --workers=auto --max-requests=1000
Restart=always
RestartSec=5

[Install]
WantedBy=multi-user.target
```

### Docker (FrankenPHP official image)

Use the official `dunglas/frankenphp` image. A minimal Dockerfile:

```dockerfile
FROM dunglas/frankenphp:latest

# Install PHP extensions required by Laravel
RUN install-php-extensions \
    pcntl \
    mbstring \
    openssl \
    tokenizer \
    xml \
    ctype \
    fileinfo \
    pdo_sqlite

WORKDIR /app
COPY . /app

RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN bun install && bun run build

RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan event:cache

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000", "--workers=auto", "--max-requests=1000"]
```

---

## Health Check

Laravel exposes a `/up` health endpoint (configured in `bootstrap/app.php`).
Use this for load balancer or container orchestration health probes:

```
GET https://your-domain.com/up
```

---

## Full Deployment Script

A typical CI/CD or manual deployment sequence:

```bash
# 1. Pull latest code
git pull origin main

# 2. Install production dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Build frontend
bun install
bun run build

# 4. Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 5. Restart Octane workers (graceful reload)
php artisan octane:reload
```

---

## Octane Compatibility Notes

This project is **fully Octane-compatible**. Key architectural properties:

| Concern | Status | Details |
|---|---|---|
| Static state | ✅ Safe | `Condorcet::$UseTimer` is set once in `boot()`, never mutated per-request |
| Election objects | ✅ Safe | Created fresh on every `render()` — no state leak between requests |
| Timer | ✅ Safe | Per-instance (`$this->timer` on each `Election`), not global |
| Singletons | ✅ Safe | No request-specific singletons registered |
| `$_SERVER` / globals | ✅ Safe | Not accessed directly |
| File uploads | ✅ Safe | Temporary files are per-request |
| Memory | ⚠️ Monitor | Condorcet computations (especially Kemeny-Young, CPO-STV) can be memory-intensive. Use `--max-requests=1000` to recycle workers periodically. The `memory_limit` is set to 512 MB in `AppServiceProvider`. |

---

## Optional Enhancements

### Response Caching

Since the app is stateless and results are deterministic for the same input,
you could add HTTP caching headers to Livewire responses. However, Livewire's
dynamic nature makes this complex — only consider it if performance profiling
warrants it.

### Rate Limiting

For a public-facing deployment, consider adding rate limiting in
`bootstrap/app.php` to protect against abuse of the computation-heavy election
methods (Kemeny-Young, CPO-STV).
