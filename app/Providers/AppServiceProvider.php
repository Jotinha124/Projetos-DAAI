<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();

        // RODAR MIGRATIONS
        $this->loadMigrationsFrom([
            database_path() . '/migrations/EstruturaLaravel',
            database_path() . '/migrations',
            database_path() . '/migrations/populate',
        ]);
    }
}
