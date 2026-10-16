# PHP 必學最小範圍（能看懂、能改、能做小型 CRUD）

先把下面檔案用 CLI 跑過一遍，再進 Laravel 專案。

```bash
php learn/01-variables.php
php learn/02-arrays-foreach.php
php learn/03-functions.php
php learn/04-conditionals.php
php learn/05-oop.php
php learn/06-exceptions.php
php learn/10-pdo-prepared.php
php learn/11-security.php
```

需要瀏覽器的：

```bash
php -S 127.0.0.1:8080 -t learn
```

然後開：

- http://127.0.0.1:8080/07-web-get-post.php
- http://127.0.0.1:8080/08-session-cookie.php
- http://127.0.0.1:8080/09-http-status.php?code=422

對照表：

| 你學的東西 | 在庫存系統哪裡用到 |
| --- | --- |
| 變數／陣列／foreach | 商品列表、異動紀錄 |
| 函式／條件 | 低庫存判斷、出庫能不能過 |
| OOP | `Product` Model、`StockService` |
| 例外 | `InsufficientStockException` |
| GET／POST／表單 | 搜尋用 GET、新增入出庫用 POST |
| Session／Cookie | 登入、記住我 |
| HTTP 狀態碼 | API 200／201／401／422 |
| PDO Prepared | Eloquent 底層就是這個 |
| CSRF／XSS／雜湊 | Blade `@csrf`、`{{ }}`、password cast |
