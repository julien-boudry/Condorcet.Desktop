# =============================================================================
# Condorcet Desktop — Production Docker Image
# =============================================================================
#
# Multi-stage build:
#   - Stage 1 (frontend): compiles Vite/Tailwind assets using Bun
#   - Stage 2 (app):      production FrankenPHP image, no Node/Bun runtime
#
# Usage:
#   docker build -t condorcet-desktop .
#   docker run --env-file .env.prod -p 80:80 -p 443:443 -p 443:443/udp condorcet-desktop
#
# For Docker Compose, use docker-compose.yml instead.
# =============================================================================

# -----------------------------------------------------------------------------
# Stage 1: Build frontend assets
# -----------------------------------------------------------------------------
FROM oven/bun:latest AS frontend

WORKDIR /app

# Install dependencies first (cached layer if package files don't change)
COPY package.json bun.lock ./
RUN bun install --frozen-lockfile

# Copy only files needed by Vite to build assets
COPY vite.config.js ./
COPY resources/ resources/
COPY public/ public/

RUN bun run build

# -----------------------------------------------------------------------------
# Stage 2: Production image
# -----------------------------------------------------------------------------
FROM dunglas/frankenphp:1-php8.5

# Composer is not bundled in the php-versioned FrankenPHP image — copy it
# from the official image instead of installing it at runtime.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP extensions required by Laravel and its dependencies.
# zip is required by nativephp/desktop.
RUN install-php-extensions \
    pcntl \
    mbstring \
    openssl \
    tokenizer \
    xml \
    ctype \
    fileinfo \
    pdo_sqlite \
    zip

WORKDIR /app

# Copy application code — vendor/ and other dev artifacts are excluded
# via .dockerignore so they never end up in the image.
COPY . /app

# Copy compiled frontend assets from the build stage
COPY --from=frontend /app/public/build /app/public/build

# Install production PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Declare the ports FrankenPHP listens on in production.
# HTTP is used for ACME HTTP challenges and HTTP->HTTPS redirection, while
# HTTPS serves the application traffic (including HTTP/2 and HTTP/3).
EXPOSE 80
EXPOSE 443
EXPOSE 443/udp

# Caddy stores TLS assets under /data and runtime config/state under /config.
# Mount named volumes for both paths (see docker-compose.yml) to persist
# certificates and related state across container restarts.
VOLUME ["/data", "/config"]

# Health check against the built-in Laravel /up endpoint.
HEALTHCHECK --interval=10s --timeout=5s --start-period=20s --retries=3 \
    CMD curl -f http://localhost/up || exit 1

# Laravel caches run at container startup so they read environment variables
# injected by the container runtime (Docker Compose env_file:, Kubernetes
# secrets, etc.) — no .env file is needed inside the image.
#
# `exec` replaces sh as PID 1 so Octane receives SIGTERM directly and
# performs a graceful shutdown instead of being killed immediately.
CMD sh -c "php artisan config:cache && \
           php artisan route:cache && \
           php artisan view:cache && \
           php artisan event:cache && \
           exec php artisan octane:frankenphp --host=\"${OCTANE_HOST:?Set OCTANE_HOST in .env (example: desktop.condorcet.vote)}\" --port=443 --workers=auto --max-requests=1000 --https --http-redirect"
