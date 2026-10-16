<?php
/**
 * Web 基礎：GET / POST / 表單
 * 瀏覽器打開此檔（需 PHP 內建伺服器或 XAMPP）
 *
 * GET  = 查詢、可書籤、出現在 URL（不要放密碼）
 * POST = 新增／修改／刪除，資料在 request body
 */

declare(strict_types=1);

$method = $_SERVER['REQUEST_METHOD'] ?? 'CLI';
$keyword = $_GET['q'] ?? '';
$message = '';

if ($method === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $qty = (int) ($_POST['qty'] ?? 0);

    if ($name === '' || $qty < 0) {
        $message = '請填商品名稱，數量不可為負';
        http_response_code(422); // Unprocessable Entity
    } else {
        $message = "已模擬新增：{$name} x {$qty}（尚未寫入資料庫）";
        http_response_code(201); // Created
    }
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>GET / POST 練習</title>
</head>
<body>
    <h1>搜尋（GET）</h1>
    <form method="get">
        <input name="q" value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>">
        <button>查詢</button>
    </form>
    <?php if ($keyword !== ''): ?>
        <p>你搜尋的是：<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <h1>新增商品（POST）</h1>
    <?php if ($message !== ''): ?>
        <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form method="post">
        <label>名稱 <input name="name" required></label>
        <label>數量 <input name="qty" type="number" min="0" required></label>
        <button>送出</button>
    </form>
    <p>目前 HTTP 方法：<?= htmlspecialchars($method, ENT_QUOTES, 'UTF-8') ?></p>
</body>
</html>
