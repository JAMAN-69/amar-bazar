<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'subtitle',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'stock',
        'image',
        'rating',
        'reviews_count',
        'is_featured',
        'is_top_selling',
        'is_available',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getEffectivePriceAttribute(): float
    {
        return $this->sale_price !== null && $this->sale_price > 0 ? (float)$this->sale_price : (float)$this->regular_price;
    }

    public function getDiscountPercentAttribute(): int
    {
        if ($this->sale_price && $this->regular_price > $this->sale_price) {
            return (int) round((($this->regular_price - $this->sale_price) / $this->regular_price) * 100);
        }
        return 0;
    }

    public function getSavedAmountAttribute(): float
    {
        if ($this->sale_price && $this->regular_price > $this->sale_price) {
            return (float) ($this->regular_price - $this->sale_price);
        }
        return 0;
    }
}
