<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use CondorcetPHP\Condorcet\Condorcet;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // The Condorcet library performs heavy combinatorial computations
        // (especially Kemeny-Young, CPO-STV) that can exceed the default 128 MB limit.
        ini_set('memory_limit', '512M');

        // Enable the Condorcet built-in timer so getGlobalTimer() returns real values
        Condorcet::$UseTimer = true;

        $this->configureDefaults();
        $this->configureRateLimiting();
    }

    /**
     * Configure rate limiters for the application.
     *
     * Limits each IP to 60 requests per minute on web routes.
     * This protects against abuse of computation-heavy election methods
     * (Kemeny-Young, CPO-STV) which are CPU and memory intensive.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('web', static fn (Request $request): Limit =>
            Limit::perMinute(60)->by($request->ip())
        );
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }
}
