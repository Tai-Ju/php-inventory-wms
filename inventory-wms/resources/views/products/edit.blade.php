@extends('layouts.app')
@section('title', '編輯商品')
@section('content')
    <header class="page-head">
        <div>
            <p class="eyebrow">Update</p>
            <h1>編輯 {{ $product->name }}</h1>
        </div>
    </header>
    <form class="panel form" method="post" action="{{ route('products.update', $product) }}">
        @method('PUT')
        @include('products._form')
        <button class="btn">儲存</button>
    </form>
@endsection
