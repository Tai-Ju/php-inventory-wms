<?php
/**
 * 函式：把「重複邏輯」抽出去，CRUD 才不會複製貼上
 */

declare(strict_types=1);

function isLowStock(int $qty, int $safety = 10): bool
{
    return $qty <= $safety;
}

function formatStockLine(string $name, int $qty, int $safety): string
{
    $status = isLowStock($qty, $safety) ? 'LOW' : 'OK';
    return sprintf('%s | qty=%d | %s', $name, $qty, $status);
}

echo formatStockLine('酒精', 8, 10) . "\n";

// 箭頭函式（Laravel collection 很常用）
$qtyList = [80, 12, 5];
$low = array_filter($qtyList, fn (int $q) => $q <= 10);
print_r($low);
