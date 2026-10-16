@if ($paginator->hasPages())
    <nav class="pager">
        @if ($paginator->onFirstPage())
            <span>上一頁</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">上一頁</a>
        @endif
        <em>{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</em>
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">下一頁</a>
        @else
            <span>下一頁</span>
        @endif
    </nav>
@endif
