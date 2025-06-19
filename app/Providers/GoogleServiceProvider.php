<?php

namespace App\Providers;

use App\Models\Google;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         try {
             // Fetch Google settings from the database first
             $googleConfig = Google::first();
             if ($googleConfig && $googleConfig->client_id && $googleConfig->secret_key) {
                 Config::set('services.google.client_id', $googleConfig->client_id);
                 Config::set('services.google.client_secret', $googleConfig->secret_key);
             }
         } catch (\Exception $e) {
             // If database is not available or table doesn't exist, fall back to .env
             // This will use the default configuration from config/services.php
         }
    }
}
