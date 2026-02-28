<?php

/**
 * Application version configuration.
 *
 * The version is read from a VERSION file at the project root. This file is
 * generated at build time (typically via a Docker build-arg injected by
 * docker-compose) and contains the output of `git describe --tags --always`.
 *
 * When running locally without a VERSION file (e.g. during development),
 * the value falls back to 'dev'.
 */
$versionFile = base_path('VERSION');

return [
    'app' => file_exists($versionFile) ? trim((string) file_get_contents($versionFile)) : 'dev',
];
