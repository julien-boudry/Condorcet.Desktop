<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Set the application locale from a URL parameter, cookie, or browser preference.
 *
 * Resolution order:
 * 1. "lang" query parameter — allows forcing a locale via the URL
 *    (e.g. /?lang=fr). Useful for sharing links in a specific language.
 *    When present and valid, the middleware sets the "locale" cookie and
 *    redirects to the same URL without the "lang" parameter. This ensures
 *    the parameter is consumed once and the cookie takes over, so that
 *    subsequent language selector changes work normally.
 * 2. "locale" cookie — explicit user choice via the language selector.
 * 3. Accept-Language header — browser/OS preference, matched against
 *    the supported locales.
 * 4. config('app.locale') — application default (en).
 *
 * The "locale" cookie is set client-side by the language selector in
 * the nav bar. It is excluded from Laravel's cookie encryption so that
 * plain JavaScript can read/write it.
 */
class SetLocale
{
    /**
     * Cookie lifetime for the locale cookie set via the "lang" query parameter.
     * One year in minutes.
     */
    private const int COOKIE_LIFETIME_MINUTES = 525_960;

    public function handle(Request $request, Closure $next): Response
    {
        $supported = config('locales.supported', []);

        // 1. "lang" query parameter — set cookie and redirect without the parameter
        $redirectResponse = $this->handleLangQueryParameter($request, $supported);

        if ($redirectResponse !== null) {
            return $redirectResponse;
        }

        // 2–4. Cookie / Accept-Language / default
        $locale = $this->resolveLocale($request, $supported);

        if ($locale !== null) {
            app()->setLocale($locale);
        }

        return $next($request);
    }

    /**
     * If a valid "lang" query parameter is present, set the locale cookie
     * and return a redirect to the same URL without the "lang" parameter.
     *
     * @param  array<string, string>  $supported  Map of locale code => display label.
     */
    private function handleLangQueryParameter(Request $request, array $supported): ?Response
    {
        $queryLocale = $request->query('lang');

        if (! \is_string($queryLocale) || ! array_key_exists($queryLocale, $supported)) {
            return null;
        }

        // Build the redirect URL without the "lang" parameter
        $targetUrl = $request->fullUrlWithoutQuery('lang');

        // Plain cookie (not encrypted, not HttpOnly) matching the client-side language selector convention.
        // httpOnly must be false so that JavaScript can later overwrite this cookie
        // when the user changes language via the dropdown selector.
        $cookie = cookie(
            name: 'locale',
            value: $queryLocale,
            minutes: self::COOKIE_LIFETIME_MINUTES,
            path: '/',
            secure: null,
            httpOnly: false,
            sameSite: 'Lax',
        );

        return redirect($targetUrl)->withCookie($cookie);
    }

    /**
     * Determine the best locale from cookie, browser header, or config fallback.
     *
     * @param  array<string, string>  $supported  Map of locale code => display label.
     */
    private function resolveLocale(Request $request, array $supported): ?string
    {
        // 2. Explicit user choice via cookie
        $cookie = $request->cookie('locale');

        if ($cookie !== null && array_key_exists($cookie, $supported)) {
            return $cookie;
        }

        // 3. Browser Accept-Language header
        $preferred = $request->getPreferredLanguage(array_keys($supported));

        if ($preferred !== null && array_key_exists($preferred, $supported)) {
            return $preferred;
        }

        // 4. Application default
        return config('app.locale');
    }
}
