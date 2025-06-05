<?php

namespace App\Services;

use App\Models\PaymentGatewaySetting;
use Cache;

class PaymentGatewaySettingService
{
    public function getSettings()
    {
        return Cache::rememberForever('gatewaySettings', function () {
            return PaymentGatewaySetting::pluck('value', 'key')->toArray(); // ['key' => 'value']
        });
    }

    public function setGlobalSettings(): void
    {
        $settings = $this->getSettings();
        config()->set('gatewaySettings', $settings);
    }

    public function clearCachedSettings(): void
    {
        Cache::forget('gatewaySettings');
    }
}
