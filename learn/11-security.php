<?php
/**
 * 安全必學：XSS / CSRF / SQL Injection / 密碼雜湊
 */

declare(strict_types=1);

// 1) XSS：輸出到 HTML 前一定要跳脫（Laravel Blade {{ }} 預設會做）
$attack = '<script>alert(1)</script>';
echo htmlspecialchars($attack, ENT_QUOTES, 'UTF-8') . "\n";

// 2) 密碼：永遠用 password_hash，不要 MD5 / SHA1
$hash = password_hash('Secret123!', PASSWORD_DEFAULT);
var_dump(password_verify('Secret123!', $hash)); // true
var_dump(password_verify('wrong', $hash));      // false

// 3) CSRF：表單放隨機 token，存在 Session，送出時比對
session_start();
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
echo 'CSRF token 範例：' . $_SESSION['csrf'] . "\n";

// 4) SQL Injection：見 10-pdo-prepared.php，永遠用綁定參數
echo "SQL 請用 PDO prepare，不要把使用者輸入接進 SQL 字串。\n";
