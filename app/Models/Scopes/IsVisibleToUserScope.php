<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;

class IsVisibleToUserScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->check() && Schema::hasColumn($model->getTable(), 'user_id') && ! auth()->user()->isAdmin()) {
            $builder->where('user_id', auth()->user()->id);
        }
    }
}
