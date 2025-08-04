<?php

namespace App\Providers;

use App\Services\PaymentGatewaySettingService;
use Illuminate\Support\ServiceProvider;
  use Illuminate\Support\Facades\Schema;

class PaymentGatewaySettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentGatewaySettingService::class, function(){
            return new PaymentGatewaySettingService();
        });
    }

    /**
     * Bootstrap services.
     */
  

public function boot(): void
{
    // avoid bootstrapping when DB schema may not be ready (e.g., fresh migrate)
    if ($this->app->runningInConsole() && in_array(
        // common migration-related commands where the table might not yet exist
        $_SERVER['argv'][1] ?? '',
        ['migrate', 'migrate:refresh', 'migrate:fresh', 'db:seed', 'migrate:install']
    )) {
        return;
    }

    if (!Schema::hasTable('payment_gateway_settings')) {
        return;
    }

    $paymentGatewaySetting = $this->app->make(PaymentGatewaySettingService::class);
    $paymentGatewaySetting->setGlobalSettings();
}

}
