@extends('layouts.app')
@section('title', '庫存看板')
@section('content')
    <header class="page-head">
        <div>
            <p class="eyebrow">Dashboard</p>
            <h1>庫存看板</h1>
        </div>
        <form class="search" method="get">
            <input name="q" value="{{ $keyword }}" placeholder="搜尋料號／品名／儲位">
            <button class="btn ghost">查詢</button>
        </form>
    </header>

    <section class="metrics">
        <article>
            <span>SKU 數</span>
            <strong>{{ $skuCount }}</strong>
        </article>
        <article>
            <span>總庫存量</span>
            <strong>{{ $totalQty }}</strong>
        </article>
        <article class="{{ $lowStockCount > 0 ? 'warn' : '' }}">
            <span>低庫存品項</span>
            <strong>{{ $lowStockCount }}</strong>
        </article>
        <article>
            <span>最近異動</span>
            <strong>{{ $recentMoves->count() }}</strong>
        </article>
    </section>

    <div class="split">
        <section class="panel">
            <h2>庫存查詢結果</h2>
            <table>
                <thead>
                    <tr>
                        <th>料號</th>
                        <th>品名</th>
                        <th>儲位</th>
                        <th>現有</th>
                        <th>安全</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                        <tr class="{{ $p->isLowStock() ? 'row-low' : '' }}">
                            <td><code>{{ $p->sku }}</code></td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->location ?: '—' }}</td>
                            <td>{{ $p->quantity }} {{ $p->unit }}</td>
                            <td>{{ $p->safety_stock }}</td>
                            <td><a href="{{ route('products.show', $p) }}">明細</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6">沒有符合的商品</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $products->links() }}
        </section>

        <section class="panel">
            <h2>低庫存提醒</h2>
            <ul class="alerts">
                @forelse($lowStockItems as $item)
                    <li>
                        <div>
                            <strong>{{ $item->name }}</strong>
                            <small>{{ $item->sku }} · {{ $item->location }}</small>
                        </div>
                        <em>{{ $item->quantity }}/{{ $item->safety_stock }}</em>
                    </li>
                @empty
                    <li>目前沒有低庫存。</li>
                @endforelse
            </ul>
            <h2>最近入出庫</h2>
            <ul class="alerts">
                @foreach($recentMoves as $m)
                    <li>
                        <div>
                            <strong>{{ $m->isInbound() ? '入庫' : '出庫' }} · {{ $m->product->name }}</strong>
                            <small>{{ $m->created_at->format('m/d H:i') }}</small>
                        </div>
                        <em>{{ $m->isInbound() ? '+' : '−' }}{{ $m->quantity }}</em>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
@endsection
