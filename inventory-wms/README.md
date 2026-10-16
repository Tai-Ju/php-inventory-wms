# 實習倉 WMS（Laravel 12）

簡易庫存：商品主檔、入庫、出庫、查詢、低庫存、JSON API。

專案說明、技術重點與畫面見上層 [`../README.md`](../README.md)。

```bash
copy .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

- Web：http://127.0.0.1:8000
- 帳號：`warehouse@example.com` / `password`
- API：[`../docs/API.md`](../docs/API.md)
