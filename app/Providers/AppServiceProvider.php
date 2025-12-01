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
        \Illuminate\Pagination\Paginator::useTailwind();
        
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
            
            // Ensure debug mode is OFF in production
            if (config('app.debug')) {
                throw new \Exception('APP_DEBUG must be set to false in production environment!');
            }
        }
    }
}
