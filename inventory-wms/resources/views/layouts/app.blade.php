<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '庫存看板') · 北護 WMS 實習倉</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="shell">
        <aside class="rail">
            <div class="brand">
                <span class="brand-mark">NT</span>
                <div>
                    <strong>實習倉 WMS</strong>
                    <small>北護 · 簡易庫存</small>
                </div>
            </div>
            <nav>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'is-on' : '' }}">庫存看板</a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'is-on' : '' }}">商品主檔</a>
                <a href="{{ route('stock.in.form') }}" class="{{ request()->routeIs('stock.in*') ? 'is-on' : '' }}">入庫</a>
                <a href="{{ route('stock.out.form') }}" class="{{ request()->routeIs('stock.out*') ? 'is-on' : '' }}">出庫</a>
                <a href="{{ route('stock.history') }}" class="{{ request()->routeIs('stock.history') ? 'is-on' : '' }}">異動紀錄</a>
                <a href="{{ route('products.index', ['low' => 1]) }}">
                    低庫存
                    @if(($lowStockCount ?? 0) > 0)
                        <span class="pill">{{ $lowStockCount }}</span>
                    @endif
                </a>
            </nav>
            <div class="rail-foot">
                <span>{{ auth()->user()->name }}</span>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="linkish">登出</button>
                </form>
            </div>
        </aside>

        <main class="stage">
            @if(session('status'))
                <div class="flash ok">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="flash bad">
                    {{ $errors->first() }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
