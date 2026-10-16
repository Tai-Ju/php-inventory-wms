<?php

use App\Http\Controllers\Api\InventoryApiController;
use App\Http\Middleware\VerifyApiToken;
use Illuminate\Support\Facades\Route;

Route::middleware(VerifyApiToken::class)->group(function () {
    Route::get('/products', [InventoryApiController::class, 'products']);
    Route::post('/products', [InventoryApiController::class, 'store']);
    Route::get('/products/{product}', [InventoryApiController::class, 'show']);
    Route::put('/products/{product}', [InventoryApiController::class, 'update']);
    Route::get('/stock/low', [InventoryApiController::class, 'lowStock']);
    Route::post('/stock/in', [InventoryApiController::class, 'inbound']);
    Route::post('/stock/out', [InventoryApiController::class, 'outbound']);
});
