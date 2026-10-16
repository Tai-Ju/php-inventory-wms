<?php
/**
 * 陣列與 foreach（列表頁幾乎都靠這兩個）
 */

declare(strict_types=1);

$product = [
    'sku' => 'SKU-001',
    'name' => '醫用口罩',
    'qty' => 80,
];

echo $product['name'] . "\n";

$items = [
    ['sku' => 'SKU-001', 'name' => '醫用口罩', 'qty' => 80],
    ['sku' => 'SKU-002', 'name' => '酒精', 'qty' => 12],
    ['sku' => 'SKU-003', 'name' => '手套', 'qty' => 5],
];

foreach ($items as $item) {
    $flag = $item['qty'] < 10 ? '⚠ 低庫存' : 'OK';
    echo "{$item['sku']} {$item['name']} {$item['qty']} {$flag}\n";
}

// 只取出欄位
$names = array_column($items, 'name');
print_r($names);
