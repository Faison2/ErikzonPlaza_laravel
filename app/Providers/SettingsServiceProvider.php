<?php

namespace App\Providers;

use App\Services\SettingsService;
   use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingsService::class, function(){
            return new SettingsService();
        });
    }

    /**
     * Bootstrap services.
     */
 

public function boot(): void
{
    // avoid running when the DB isn't ready yet (e.g., during initial migrate or if the table is missing)
    if ($this->app->runningInConsole() && !app()->environment('production')) {
        // optional: skip during artisan migrate/seeding to prevent bootstrap errors
        return;
    }

    if (!Schema::hasTable('settings')) {
        // you could log or silently skip
        return;
    }

    $settingsService = $this->app->make(SettingsService::class);
    $settingsService->setGlobalSettings();
}

}
