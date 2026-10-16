<?php
/**
 * 物件導向基礎：對應 Laravel 的 Model / Controller
 */

declare(strict_types=1);

class Product
{
    public function __construct(
        public string $sku,
        public string $name,
        public int $qty,
        public int $safetyStock = 10,
    ) {
    }

    public function isLow(): bool
    {
        return $this->qty <= $this->safetyStock;
    }

    public function stockIn(int $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('入庫數量必須 > 0');
        }
        $this->qty += $amount;
    }

    public function stockOut(int $amount): void
    {
        if ($amount > $this->qty) {
            throw new RuntimeException('庫存不足');
        }
        $this->qty -= $amount;
    }
}

$mask = new Product('SKU-001', '醫用口罩', 8);
echo $mask->name . ' 低庫存？ ' . ($mask->isLow() ? '是' : '否') . "\n";
$mask->stockIn(20);
echo "入庫後：{$mask->qty}\n";
