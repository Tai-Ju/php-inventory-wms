<?php
/**
 * 條件判斷：出庫前一定要檢查庫存夠不夠
 */

declare(strict_types=1);

function canStockOut(int $onHand, int $requestQty): string
{
    if ($requestQty <= 0) {
        return '數量必須大於 0';
    }

    if ($requestQty > $onHand) {
        return '庫存不足，拒絕出庫';
    }

    return '允許出庫';
}

echo canStockOut(10, 3) . "\n";
echo canStockOut(10, 20) . "\n";

$role = 'warehouse';
switch ($role) {
    case 'admin':
        echo "可刪商品\n";
        break;
    case 'warehouse':
        echo "可入庫／出庫\n";
        break;
    default:
        echo "只能查詢\n";
}
