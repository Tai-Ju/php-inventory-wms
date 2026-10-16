<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    public const TYPE_IN = 'in';
    public const TYPE_OUT = 'out';

    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'before_qty',
        'after_qty',
        'remark',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'before_qty' => 'integer',
            'after_qty' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isInbound(): bool
    {
        return $this->type === self::TYPE_IN;
    }
}
