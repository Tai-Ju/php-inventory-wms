<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::defaultView('pagination.simple');

        View::composer('layouts.app', function ($view) {
            $lowStockCount = 0;
            try {
                $lowStockCount = Product::query()->lowStock()->count();
            } catch (\Throwable) {
                // migrate 尚未執行時不要炸掉畫面
            }
            $view->with('lowStockCount', $lowStockCount);
        });
    }
}
