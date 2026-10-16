<?php

namespace App\Services;

use App\Exceptions\InsufficientStockException;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StockService
{
    public function inbound(Product $product, int $qty, ?string $remark, ?User $user): StockMovement
    {
        return DB::transaction(function () use ($product, $qty, $remark, $user) {
            $locked = Product::query()->lockForUpdate()->findOrFail($product->id);
            $before = $locked->quantity;
            $locked->quantity = $before + $qty;
            $locked->save();

            return StockMovement::query()->create([
                'product_id' => $locked->id,
                'user_id' => $user?->id,
                'type' => StockMovement::TYPE_IN,
                'quantity' => $qty,
                'before_qty' => $before,
                'after_qty' => $locked->quantity,
                'remark' => $remark,
            ]);
        });
    }

    public function outbound(Product $product, int $qty, ?string $remark, ?User $user): StockMovement
    {
        return DB::transaction(function () use ($product, $qty, $remark, $user) {
            $locked = Product::query()->lockForUpdate()->findOrFail($product->id);
            $before = $locked->quantity;

            if ($qty > $before) {
                throw InsufficientStockException::for($locked->sku, $before, $qty);
            }

            $locked->quantity = $before - $qty;
            $locked->save();

            return StockMovement::query()->create([
                'product_id' => $locked->id,
                'user_id' => $user?->id,
                'type' => StockMovement::TYPE_OUT,
                'quantity' => $qty,
                'before_qty' => $before,
                'after_qty' => $locked->quantity,
                'remark' => $remark,
            ]);
        });
    }
}
