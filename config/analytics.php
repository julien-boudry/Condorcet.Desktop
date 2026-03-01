<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Analytics — Rybbit.io
    |--------------------------------------------------------------------------
    |
    | These settings control the Rybbit analytics integration for the web
    | version of Condorcet Desktop. Analytics are never loaded in NativePHP
    | desktop builds (they are a web-only concern).
    |
    | ANALYTICS_ENABLED   — Master switch. Set to true to enable analytics.
    | ANALYTICS_SCRIPT_URL — Full URL to the Rybbit tracking script. Change
    |                         this when self-hosting an open-source instance.
    | ANALYTICS_SITE_ID   — The numeric / string site ID from the Rybbit
    |                         dashboard (data-site-id attribute on the script).
    |
    */

    'enabled' => (bool) env('ANALYTICS_ENABLED', false),

    'script_url' => env('ANALYTICS_SCRIPT_URL', 'https://app.rybbit.io/api/script.js'),

    'site_id' => env('ANALYTICS_SITE_ID', ''),

];
