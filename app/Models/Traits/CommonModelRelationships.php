<?php

namespace App\Models\Traits;

use function auth;

trait CommonModelRelationships
{
    public function isAdmin(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public function isSeller(): bool
    {
        return auth()->user()->hasRole('seller');
    }

    public function isCustomer(): bool
    {
        return auth()->user()->hasRole('user');
    }

    public function isAdminOrSeller(): bool
    {
        return auth()->user()->hasRole('admin') || auth()->user()->hasRole('seller');
    }
}
