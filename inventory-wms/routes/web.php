<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('/stock/in', [StockController::class, 'inboundForm'])->name('stock.in.form');
    Route::post('/stock/in', [StockController::class, 'inbound'])->name('stock.in');
    Route::get('/stock/out', [StockController::class, 'outboundForm'])->name('stock.out.form');
    Route::post('/stock/out', [StockController::class, 'outbound'])->name('stock.out');
    Route::get('/stock/history', [StockController::class, 'history'])->name('stock.history');
});
