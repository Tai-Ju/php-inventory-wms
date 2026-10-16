# 實習倉 WMS API

Base URL：`http://127.0.0.1:8000/api`

認證：`Authorization: Bearer <token>`

- 示範帳號的 token（`php artisan db:seed` 之後）：`demo-api-token`
- 自行註冊時，token **只會在註冊成功閃訊顯示一次**，資料庫只存 SHA-256 雜湊

所有寫入走 Eloquent／PDO Prepared Statements，不拼接 SQL。

## 狀態碼

| 碼 | 意義 |
| --- | --- |
| 200 | 查詢／更新成功 |
| 201 | 新增成功（商品或入出庫） |
| 401 | 沒帶 token 或 token 無效 |
| 404 | 找不到商品 |
| 422 | 驗證失敗或庫存不足 |
| 500 | 伺服器例外 |

## 端點

### `GET /api/products`

Query：`q`（關鍵字）、`low=1`（只回低庫存）

### `GET /api/products/{id}`

含異動歷史。

### `POST /api/products`

```json
{
  "sku": "MED-NEW-01",
  "name": "彈性繃帶",
  "unit": "捲",
  "safety_stock": 8,
  "location": "B-02-04",
  "notes": "無菌包裝"
}
```

### `PUT /api/products/{id}`

欄位同 POST。

### `GET /api/stock/low`

低庫存清單（`quantity <= safety_stock`）。

### `POST /api/stock/in`

```json
{
  "product_id": 1,
  "quantity": 20,
  "remark": "進貨單 PO-2026-001"
}
```

### `POST /api/stock/out`

欄位同入庫。庫存不足回 422。

## curl 範例

```bash
curl -H "Authorization: Bearer demo-api-token" http://127.0.0.1:8000/api/products
curl -H "Authorization: Bearer demo-api-token" http://127.0.0.1:8000/api/stock/low

curl -X POST http://127.0.0.1:8000/api/stock/in ^
  -H "Authorization: Bearer demo-api-token" ^
  -H "Content-Type: application/json" ^
  -d "{\"product_id\":1,\"quantity\":5,\"remark\":\"demo inbound\"}"
```
