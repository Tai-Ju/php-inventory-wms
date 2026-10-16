@extends('layouts.app')
@section('title', '新增商品')
@section('content')
    <header class="page-head">
        <div>
            <p class="eyebrow">Create</p>
            <h1>新增商品</h1>
        </div>
    </header>
    <form class="panel form" method="post" action="{{ route('products.store') }}">
        @include('products._form')
        <button class="btn">建立（庫存從 0 開始）</button>
    </form>
@endsection
