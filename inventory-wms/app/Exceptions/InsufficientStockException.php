<?php

namespace App\Exceptions;

use RuntimeException;

class InsufficientStockException extends RuntimeException
{
    public static function for(string $sku, int $onHand, int $requested): self
    {
        return new self("SKU {$sku} 庫存不足（現有 {$onHand}，欲出庫 {$requested}）");
    }
}
