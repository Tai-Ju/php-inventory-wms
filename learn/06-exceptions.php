<?php
/**
 * 例外處理：出庫失敗不要讓整個網站白屏
 */

declare(strict_types=1);

class Product
{
    public function __construct(
        public string $sku,
        public string $name,
        public int $qty,
    ) {
    }

    public function stockOut(int $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('出庫數量必須 > 0');
        }
        if ($amount > $this->qty) {
            throw new RuntimeException('庫存不足');
        }
        $this->qty -= $amount;
    }
}

function safeStockOut(Product $product, int $qty): string
{
    try {
        $product->stockOut($qty);
        return "出庫成功，剩餘 {$product->qty}";
    } catch (InvalidArgumentException $e) {
        return '輸入錯誤：' . $e->getMessage();
    } catch (RuntimeException $e) {
        return '業務錯誤：' . $e->getMessage();
    } catch (Throwable $e) {
        return '未知錯誤，請查 log';
    }
}

$alcohol = new Product('SKU-002', '酒精', 5);
echo safeStockOut($alcohol, 99) . "\n";
echo safeStockOut($alcohol, 2) . "\n";
