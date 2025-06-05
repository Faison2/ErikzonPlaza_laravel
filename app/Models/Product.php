<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends BaseModel
{
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function productSizes(): HasMany
    {
        return $this->hasMany(ProductSize::class);
    }

    public function productOptions(): HasMany
    {
        return $this->hasMany(ProductOption::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductRating::class, 'product_id', 'id');
    }
}
