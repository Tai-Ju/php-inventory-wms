<?php
/**
 * Session / Cookie
 * Session：存在伺服器，適合登入狀態
 * Cookie：存在瀏覽器，適合「記住我」、偏好設定（不要存密碼）
 */

declare(strict_types=1);

session_start();

if (isset($_GET['login'])) {
    $_SESSION['user'] = 'warehouse01';
    setcookie('remember_role', 'warehouse', [
        'expires' => time() + 3600,
        'path' => '/',
        'httponly' => true, // JS 讀不到，降低 XSS 偷 cookie 風險
        'samesite' => 'Lax',
    ]);
    header('Location: 08-session-cookie.php');
    exit;
}

if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    setcookie('remember_role', '', time() - 3600, '/');
    header('Location: 08-session-cookie.php');
    exit;
}

$user = $_SESSION['user'] ?? '訪客';
$role = $_COOKIE['remember_role'] ?? '無';
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<meta charset="UTF-8">
<title>Session / Cookie</title>
<body>
    <p>Session 使用者：<?= htmlspecialchars($user, ENT_QUOTES, 'UTF-8') ?></p>
    <p>Cookie 角色：<?= htmlspecialchars((string) $role, ENT_QUOTES, 'UTF-8') ?></p>
    <a href="?login=1">模擬登入</a> |
    <a href="?logout=1">登出</a>
</body>
</html>
