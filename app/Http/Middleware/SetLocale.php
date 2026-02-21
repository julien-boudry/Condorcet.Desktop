<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Set the application locale from a cookie.
 *
 * The "locale" cookie is set client-side by the language selector in
 * the nav bar. It is excluded from Laravel's cookie encryption so that
 * plain JavaScript can read/write it.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->cookie('locale', config('app.locale'));

        if (array_key_exists($locale, config('locales.supported', []))) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
