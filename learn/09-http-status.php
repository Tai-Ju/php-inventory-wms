<?php
/**
 * 常見 HTTP 狀態碼（面試＋API 文件都要用）
 *
 * 200 OK           成功讀取
 * 201 Created      新增成功
 * 204 No Content   刪除成功（通常沒有 body）
 * 302 Found        重新導向（表單 POST 後常用）
 * 401 Unauthorized 未登入
 * 403 Forbidden    已登入但沒權限
 * 404 Not Found    找不到資源
 * 419              Laravel：CSRF token 過期／缺失
 * 422              驗證失敗
 * 500              伺服器錯誤
 */

declare(strict_types=1);

$code = (int) ($_GET['code'] ?? 200);
http_response_code($code);

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'status' => $code,
    'hint' => match ($code) {
        200 => '查詢成功',
        201 => '商品已建立',
        401 => '請先登入',
        404 => '找不到 SKU',
        422 => '欄位驗證失敗',
        500 => '伺服器例外',
        default => '自訂狀態碼',
    },
], JSON_UNESCAPED_UNICODE);
