<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xendit\Configuration;

class XenditServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('xendit', function ($app) {
            Configuration::setXenditKey(config('xendit.secret_key'));
            return true; // Configuration is set globally
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
