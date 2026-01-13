<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // RODAR MIGRATIONS
        $this->loadMigrationsFrom([
            database_path() . '/migrations/EstruturaLaravel',
            database_path() . '/migrations',
            database_path() . '/migrations/populate',
        ]);
    }
}
