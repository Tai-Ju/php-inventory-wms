@extends('layouts.app')
@section('title', $product->name)
@section('content')
    <header class="page-head">
        <div>
            <p class="eyebrow">{{ $product->sku }}</p>
            <h1>{{ $product->name }}</h1>
            <p>儲位 {{ $product->location ?: '—' }} · 單位 {{ $product->unit }}</p>
        </div>
        <div class="actions">
            <a class="btn" href="{{ route('stock.in.form', ['product_id' => $product->id]) }}">入庫</a>
            <a class="btn ghost" href="{{ route('stock.out.form', ['product_id' => $product->id]) }}">出庫</a>
            <a class="btn ghost" href="{{ route('products.edit', $product) }}">編輯</a>
            <form method="post" action="{{ route('products.destroy', $product) }}" data-confirm="確定刪除此商品？異動紀錄會一併刪除。">
                @csrf
                @method('DELETE')
                <button class="btn danger" type="submit">刪除</button>
            </form>
        </div>
    </header>

    <section class="metrics">
        <article class="{{ $product->isLowStock() ? 'warn' : '' }}">
            <span>現有庫存</span>
            <strong>{{ $product->quantity }}</strong>
        </article>
        <article>
            <span>安全庫存</span>
            <strong>{{ $product->safety_stock }}</strong>
        </article>
    </section>

    @if($product->notes)
        <p class="panel">{{ $product->notes }}</p>
    @endif

    <section class="panel">
        <h2>異動歷史</h2>
        <table>
            <thead>
                <tr>
                    <th>時間</th>
                    <th>類型</th>
                    <th>數量</th>
                    <th>異動前 → 後</th>
                    <th>人員</th>
                    <th>備註</th>
                </tr>
            </thead>
            <tbody>
                @forelse($product->movements as $m)
                    <tr>
                        <td>{{ $m->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $m->isInbound() ? '入庫' : '出庫' }}</td>
                        <td>{{ $m->quantity }}</td>
                        <td>{{ $m->before_qty }} → {{ $m->after_qty }}</td>
                        <td>{{ $m->user->name ?? '系統' }}</td>
                        <td>{{ $m->remark ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">尚無異動</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
