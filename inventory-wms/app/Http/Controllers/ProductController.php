<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = trim((string) $request->query('q', ''));
        $onlyLow = $request->boolean('low');

        $products = Product::query()
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($inner) use ($keyword) {
                    $inner->where('sku', 'like', "%{$keyword}%")
                        ->orWhere('name', 'like', "%{$keyword}%");
                });
            })
            ->when($onlyLow, fn ($query) => $query->lowStock())
            ->orderBy('sku')
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products', 'keyword', 'onlyLow'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        Product::query()->create([
            ...$request->validated(),
            'quantity' => 0,
        ]);

        return redirect()->route('products.index')->with('status', '商品已建立，庫存為 0，請進行入庫。');
    }

    public function show(Product $product): View
    {
        $product->load(['movements.user']);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('products.show', $product)->with('status', '商品資料已更新。');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')->with('status', '商品已刪除。');
    }
}
