<?php

/**
 * Supported application locales.
 *
 * This is the single source of truth for all locale-related logic:
 * - The SetLocale middleware validates cookies against this list.
 * - The language selector in the navigation bar iterates over this list.
 *
 * To add a new language, create the corresponding `lang/{code}/` directory
 * with a `ui.php` translation file, then add its entry here.
 *
 * @var array<string, string> Map of locale code => display label.
 */
return [
    'supported' => [
        'en' => 'English',
        'fr' => 'Français',
        'zh' => '中文',
        'ja' => '日本語',
        'eo' => 'Esperanto',
        'it' => 'Italiano',
        'hi' => 'हिन्दी',
    ],
];
