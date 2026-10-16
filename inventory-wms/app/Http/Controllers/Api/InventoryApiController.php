<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InsufficientStockException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\StockMovementRequest;
use App\Models\Product;
use App\Services\StockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryApiController extends Controller
{
    public function __construct(private StockService $stockService)
    {
    }

    public function products(Request $request): JsonResponse
    {
        $products = Product::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->string('q')->toString();
                $query->where(function ($inner) use ($q) {
                    $inner->where('sku', 'like', "%{$q}%")
                        ->orWhere('name', 'like', "%{$q}%");
                });
            })
            ->when($request->boolean('low'), fn ($q) => $q->lowStock())
            ->orderBy('sku')
            ->paginate(20);

        return response()->json($products);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product->load('movements'));
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = Product::query()->create([
            ...$request->validated(),
            'quantity' => 0,
        ]);

        return response()->json($product, 201);
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json($product);
    }

    public function inbound(StockMovementRequest $request): JsonResponse
    {
        $product = Product::query()->findOrFail($request->integer('product_id'));
        $move = $this->stockService->inbound(
            $product,
            $request->integer('quantity'),
            $request->input('remark'),
            $request->user(),
        );

        return response()->json(['movement' => $move, 'product' => $product->fresh()], 201);
    }

    public function outbound(StockMovementRequest $request): JsonResponse
    {
        $product = Product::query()->findOrFail($request->integer('product_id'));

        try {
            $move = $this->stockService->outbound(
                $product,
                $request->integer('quantity'),
                $request->input('remark'),
                $request->user(),
            );
        } catch (InsufficientStockException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['movement' => $move, 'product' => $product->fresh()], 201);
    }

    public function lowStock(): JsonResponse
    {
        return response()->json(Product::query()->lowStock()->orderBy('quantity')->get());
    }
}
