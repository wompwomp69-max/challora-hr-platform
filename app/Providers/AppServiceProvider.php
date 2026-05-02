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
        // Share Git Tag Version globally
        $version = cache()->remember('app_version', 3600, function() {
            try {
                $tag = shell_exec('git describe --tags --abbrev=0');
                return $tag ? trim($tag) : '2.2.1';
            } catch (\Exception $e) {
                return '2.2.1';
            }
        });

        view()->share('appVersion', $version);
    }
}
