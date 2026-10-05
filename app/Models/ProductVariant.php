<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'price',
        'sku',
        'barcode',
        'stock_quantity',
        'options',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock_quantity' => 'integer',
        'options' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function hasStock(int $quantity = 1): bool
    {
        return $this->stock_quantity >= $quantity;
    }

    public function decrementStock(int $quantity = 1): bool
    {
        return $this->decrement('stock_quantity', $quantity) >= 0;
    }

    public function incrementStock(int $quantity = 1): bool
    {
        return $this->increment('stock_quantity', $quantity) >= 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price / 100, 2, ',', ' ');
    }
}
