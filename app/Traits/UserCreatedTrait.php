<?php

namespace App\Traits;

trait UserCreatedTrait
{
    public static function bootUserCreatedTrait(): void
    {
        //        static::created(function ($model) {
        //            if (! empty($model->role)) {
        //                $model->assignRole($model->role);
        //            }
        //        });
    }
}
