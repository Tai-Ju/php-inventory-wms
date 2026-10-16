@extends('layouts.app')
@section('title', '商品主檔')
@section('content')
    <header class="page-head">
        <div>
            <p class="eyebrow">Master Data</p>
            <h1>商品主檔</h1>
        </div>
        <a class="btn" href="{{ route('products.create') }}">新增商品</a>
    </header>

    <form class="toolbar" method="get">
        <input name="q" value="{{ $keyword }}" placeholder="料號或品名">
        <label class="inline">
            <input type="checkbox" name="low" value="1" @checked($onlyLow)> 只看低庫存
        </label>
        <button class="btn ghost">篩選</button>
    </form>

    <div class="cards">
        @forelse($products as $p)
            <article class="card {{ $p->isLowStock() ? 'card-low' : '' }}">
                <header>
                    <code>{{ $p->sku }}</code>
                    @if($p->isLowStock())
                        <span class="tag">LOW</span>
                    @endif
                </header>
                <h3>{{ $p->name }}</h3>
                <p>{{ $p->location ?: '未指定儲位' }} · {{ $p->quantity }} {{ $p->unit }}</p>
                <footer>
                    <a href="{{ route('products.show', $p) }}">查看</a>
                    <a href="{{ route('products.edit', $p) }}">編輯</a>
                    <a href="{{ route('stock.in.form', ['product_id' => $p->id]) }}">入庫</a>
                    <a href="{{ route('stock.out.form', ['product_id' => $p->id]) }}">出庫</a>
                </footer>
            </article>
        @empty
            <p>尚無商品，請先新增。</p>
        @endforelse
    </div>
    {{ $products->links() }}
@endsection
