<?php

namespace App\Models;

use App\Models\Scopes\IsVisibleToUserScope;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(new IsVisibleToUserScope);
    }
}
