@php
    $isIn = $mode === 'in';
@endphp
@extends('layouts.app')
@section('title', $isIn ? '入庫' : '出庫')
@section('content')
    <header class="page-head">
        <div>
            <p class="eyebrow">{{ $isIn ? 'Inbound' : 'Outbound' }}</p>
            <h1>{{ $isIn ? '入庫作業' : '出庫作業' }}</h1>
        </div>
    </header>

    <form class="panel form" method="post" action="{{ $isIn ? route('stock.in') : route('stock.out') }}">
        @csrf
        <label>商品
            <select name="product_id" required>
                <option value="">請選擇</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" @selected((int) old('product_id', $selectedId) === $p->id)>
                        {{ $p->sku }} {{ $p->name }}（現有 {{ $p->quantity }} {{ $p->unit }}）
                    </option>
                @endforeach
            </select>
        </label>
        @error('product_id')<small class="err">{{ $message }}</small>@enderror

        <label>數量
            <input type="number" min="1" name="quantity" value="{{ old('quantity') }}" required>
        </label>
        @error('quantity')<small class="err">{{ $message }}</small>@enderror

        <label>備註（單號／用途）
            <input name="remark" value="{{ old('remark') }}">
        </label>

        <button class="btn">{{ $isIn ? '確認入庫' : '確認出庫' }}</button>
    </form>
@endsection
