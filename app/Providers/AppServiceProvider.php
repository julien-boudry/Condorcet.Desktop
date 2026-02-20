<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use CondorcetPHP\Condorcet\Condorcet;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
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
