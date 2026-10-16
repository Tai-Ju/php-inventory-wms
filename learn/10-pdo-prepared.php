<?php
/**
 * PDO + Prepared Statements（避免 SQL Injection 的正確寫法）
 *
 * 錯： "SELECT * FROM products WHERE sku = '$sku'"
 * 對： 用 ? 或 :sku 佔位符，再 bind
 */

declare(strict_types=1);

$dbFile = __DIR__ . '/storage-demo.sqlite';
$pdo = new PDO('sqlite:' . $dbFile, null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$pdo->exec('CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    sku TEXT UNIQUE NOT NULL,
    name TEXT NOT NULL,
    qty INTEGER NOT NULL DEFAULT 0
)');

$pdo->prepare('INSERT OR IGNORE INTO products (sku, name, qty) VALUES (?, ?, ?)')
    ->execute(['SKU-001', '醫用口罩', 80]);

// 模擬駭客輸入
$evil = "SKU-001' OR '1'='1";

$stmt = $pdo->prepare('SELECT * FROM products WHERE sku = :sku');
$stmt->execute(['sku' => $evil]);
$row = $stmt->fetch();

echo $row ? "不該找到資料，卻找到了\n" : "Prepared Statement 擋住了注入，找不到這筆 SKU。\n";

$ok = $pdo->prepare('SELECT * FROM products WHERE sku = :sku');
$ok->execute(['sku' => 'SKU-001']);
print_r($ok->fetch());
