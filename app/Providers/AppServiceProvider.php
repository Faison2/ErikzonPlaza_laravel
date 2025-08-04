<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
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
        Paginator::useBootstrap();

        // Only run this if not in console and the settings table exists
        if (!App::runningInConsole() && Schema::hasTable('settings')) {
            $keys = ['pusher_app_id', 'pusher_cluster', 'pusher_key', 'pusher_secret'];
            $pusherConf = Setting::whereIn('key', $keys)->pluck('value', 'key');

            config(['broadcasting.connections.pusher.key' => $pusherConf['pusher_key'] ?? '']);
            config(['broadcasting.connections.pusher.secret' => $pusherConf['pusher_secret'] ?? '']);
            config(['broadcasting.connections.pusher.app_id' => $pusherConf['pusher_app_id'] ?? '']);
            config(['broadcasting.connections.pusher.options.cluster' => $pusherConf['pusher_cluster'] ?? '']);
        }
    }
}
