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

## 學習順序

### 1. 語法能跑（`01`～`06`）

逐檔執行，改數字、改條件，直到能自己寫出「庫存不足就拒絕出庫」。

### 2. Web 與資料庫（`07`～`11`）

重點記住四句話：

- 查詢用 GET，寫入用 POST。
- 登入狀態放 Session，不要把密碼放 Cookie。
- SQL 永遠用綁定參數，不要把使用者輸入接進字串。
- 輸出 HTML 要跳脫（Blade 的 `{{ }}`），表單加 CSRF。

### 3. 讀庫存系統的程式

把系統跑起來，照這條路操作一遍，再對照原始碼：

1. 登入（Session、CSRF、`password` 的 hashed cast）
2. 看板查庫存、看低庫存紅字
3. 新增商品 → 編輯 → 入庫 → 出庫（數量大於庫存應被擋）
4. 異動紀錄
5. 用 curl 打 `/api/stock/low`

| 觀念 | 檔案 |
| --- | --- |
| Route | `inventory-wms/routes/web.php`、`routes/api.php` |
| Controller | `app/Http/Controllers/*` |
| Validation | `app/Http/Requests/*` |
| Eloquent | `app/Models/Product.php`、`StockMovement.php` |
| 入出庫交易 | `app/Services/StockService.php` |
| Migration | `database/migrations/*` |
| Middleware | `app/Http/Middleware/Authenticate.php`、`VerifyApiToken.php` |
| Blade | `resources/views/*` |
