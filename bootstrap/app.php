<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            ThrottleRequests::class.':web',
            SetLocale::class,
        ]);

        // The "locale" cookie is set by client-side JS — it must not be encrypted.
        $middleware->encryptCookies(except: ['locale']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
