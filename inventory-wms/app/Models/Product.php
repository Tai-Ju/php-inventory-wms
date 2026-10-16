<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'unit',
        'quantity',
        'safety_stock',
        'location',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'safety_stock' => 'integer',
        ];
    }

    public function movements(): HasMany
    {
        return $this->hasMany(StockMovement::class)->latest();
    }

    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereColumn('quantity', '<=', 'safety_stock');
    }

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->safety_stock;
    }
}
