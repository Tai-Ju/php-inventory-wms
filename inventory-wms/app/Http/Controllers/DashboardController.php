<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $keyword = trim((string) $request->query('q', ''));

        $products = Product::query()
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($inner) use ($keyword) {
                    $inner->where('sku', 'like', "%{$keyword}%")
                        ->orWhere('name', 'like', "%{$keyword}%")
                        ->orWhere('location', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('sku')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard', [
            'products' => $products,
            'keyword' => $keyword,
            'skuCount' => Product::query()->count(),
            'totalQty' => (int) Product::query()->sum('quantity'),
            'lowStockCount' => Product::query()->lowStock()->count(),
            'recentMoves' => StockMovement::query()->with('product')->latest()->limit(8)->get(),
            'lowStockItems' => Product::query()->lowStock()->orderBy('quantity')->limit(8)->get(),
        ]);
    }
}
