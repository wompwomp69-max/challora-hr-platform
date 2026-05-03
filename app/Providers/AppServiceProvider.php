<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Share Git Tag Version globally
        // Hardcoded for now to ensure Railway BUILD succeeds.
        // Cache/Database logic during boot often crashes Railway Nixpacks build.
        $version = '2.2.1';
        View::share('appVersion', $version);
    }
}
