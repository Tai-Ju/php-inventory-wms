@extends('layouts.app')
@section('title', '異動紀錄')
@section('content')
    <header class="page-head">
        <div>
            <p class="eyebrow">Ledger</p>
            <h1>入出庫紀錄</h1>
        </div>
        <div class="actions">
            <a class="btn ghost" href="{{ route('stock.history') }}">全部</a>
            <a class="btn ghost" href="{{ route('stock.history', ['type' => 'in']) }}">只看入庫</a>
            <a class="btn ghost" href="{{ route('stock.history', ['type' => 'out']) }}">只看出庫</a>
        </div>
    </header>

    <section class="panel">
        <table>
            <thead>
                <tr>
                    <th>時間</th>
                    <th>類型</th>
                    <th>商品</th>
                    <th>數量</th>
                    <th>庫存變化</th>
                    <th>人員</th>
                    <th>備註</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $m)
                    <tr>
                        <td>{{ $m->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $m->isInbound() ? '入庫' : '出庫' }}</td>
                        <td>{{ $m->product->sku }} {{ $m->product->name }}</td>
                        <td>{{ $m->quantity }}</td>
                        <td>{{ $m->before_qty }} → {{ $m->after_qty }}</td>
                        <td>{{ $m->user->name ?? '—' }}</td>
                        <td>{{ $m->remark ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7">尚無紀錄</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $movements->links() }}
    </section>
@endsection
