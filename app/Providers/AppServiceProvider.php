<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
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
        URL::forceScheme('https');

        $version = env('APP_VERSION');

        // If APP_VERSION not set (e.g. local dev), try to read from git tag
        if (!$version) {
            $tag = trim(shell_exec('git describe --tags --abbrev=0 2>/dev/null') ?? '');
            $version = $tag ?: '4.3.8';
        }

        View::share('appVersion', $version);
    }
}
