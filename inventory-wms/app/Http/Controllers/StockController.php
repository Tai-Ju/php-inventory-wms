<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientStockException;
use App\Http\Requests\StockMovementRequest;
use App\Models\Product;
use App\Models\StockMovement;
use App\Services\StockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockController extends Controller
{
    public function __construct(private StockService $stockService)
    {
    }

    public function inboundForm(Request $request): View
    {
        return view('stock.form', [
            'mode' => 'in',
            'products' => Product::query()->orderBy('sku')->get(),
            'selectedId' => $request->integer('product_id') ?: null,
        ]);
    }

    public function inbound(StockMovementRequest $request): RedirectResponse
    {
        $product = Product::query()->findOrFail($request->integer('product_id'));
        $this->stockService->inbound(
            $product,
            $request->integer('quantity'),
            $request->input('remark'),
            $request->user(),
        );

        return redirect()->route('products.show', $product)->with('status', '入庫完成。');
    }

    public function outboundForm(Request $request): View
    {
        return view('stock.form', [
            'mode' => 'out',
            'products' => Product::query()->orderBy('sku')->get(),
            'selectedId' => $request->integer('product_id') ?: null,
        ]);
    }

    public function outbound(StockMovementRequest $request): RedirectResponse
    {
        $product = Product::query()->findOrFail($request->integer('product_id'));

        try {
            $this->stockService->outbound(
                $product,
                $request->integer('quantity'),
                $request->input('remark'),
                $request->user(),
            );
        } catch (InsufficientStockException $e) {
            return back()->withErrors(['quantity' => $e->getMessage()])->withInput();
        }

        return redirect()->route('products.show', $product)->with('status', '出庫完成。');
    }

    public function history(Request $request): View
    {
        $type = $request->query('type');

        $movements = StockMovement::query()
            ->with(['product', 'user'])
            ->when(in_array($type, ['in', 'out'], true), fn ($q) => $q->where('type', $type))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('stock.history', compact('movements', 'type'));
    }
}
