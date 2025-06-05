<?php

namespace App\Providers;

use App\Services\PaymentGatewaySettingService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class PaymentGatewaySettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentGatewaySettingService::class, function () {
            return new PaymentGatewaySettingService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $paymentGatewaySetting = $this->app->make(PaymentGatewaySettingService::class);
        if (Schema::hasTable('payment_gateway_settings')) {
            $paymentGatewaySetting->setGlobalSettings();
        }
    }
}
