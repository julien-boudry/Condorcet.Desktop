<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Set the application locale from a cookie or browser preference.
 *
 * Resolution order:
 * 1. "locale" cookie — explicit user choice via the language selector.
 * 2. Accept-Language header — browser/OS preference, matched against
 *    the supported locales.
 * 3. config('app.locale') — application default (en).
 *
 * The "locale" cookie is set client-side by the language selector in
 * the nav bar. It is excluded from Laravel's cookie encryption so that
 * plain JavaScript can read/write it.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = config('locales.supported', []);

        $locale = $this->resolveLocale($request, $supported);

        if ($locale !== null) {
            app()->setLocale($locale);
        }

        return $next($request);
    }

    /**
     * Determine the best locale from cookie, browser header, or config fallback.
     *
     * @param  array<string, string>  $supported  Map of locale code => display label.
     */
    private function resolveLocale(Request $request, array $supported): ?string
    {
        // 1. Explicit user choice via cookie
        $cookie = $request->cookie('locale');

        if ($cookie !== null && array_key_exists($cookie, $supported)) {
            return $cookie;
        }

        // 2. Browser Accept-Language header
        $preferred = $request->getPreferredLanguage(array_keys($supported));

        if ($preferred !== null && array_key_exists($preferred, $supported)) {
            return $preferred;
        }

        // 3. Application default
        return config('app.locale');
    }
}
