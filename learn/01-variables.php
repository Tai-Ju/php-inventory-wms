<?php
/**
 * PHP 基礎：變數與型別
 * 執行：php learn/01-variables.php
 */

declare(strict_types=1); // 建議開啟：型別錯誤會立刻被抓到

$name = '醫材庫存';          // string
$qty = 120;                 // int
$price = 39.5;              // float
$isActive = true;           // bool
$note = null;               // null（尚未填寫）

echo "商品：{$name}\n";
echo '庫存：' . $qty . "\n";

// 型別轉換（面試常問）
$fromForm = '50';           // 表單送來的永遠是字串
$asInt = (int) $fromForm;   // 50
var_dump($asInt);

// 常數：一旦定義就不能改
const LOW_STOCK = 10;
echo '低庫存門檻：' . LOW_STOCK . "\n";
