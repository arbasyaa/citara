@props(['paginator'])
@php
    $p = $paginator;
    $current = $p->currentPage();
    $last = $p->lastPage();
    $start = max(1, $current - 2);
    $end = min($last, $current + 2);
    // Expand window if near edges
    if ($current <= 3) { $end = min(5, $last); }
    if ($current >= $last - 2) { $start = max(1, $last - 4); }
@endphp

<div class="mt-12 flex flex-col items-center gap-4">
    <nav class="flex items-center space-x-2" aria-label="Pagination">
        {{-- Previous --}}
        @if($p->onFirstPage())
            <span class="px-3 py-2 rounded-md bg-gray-200 text-gray-400">‹</span>
        @else
            <a href="{{ $p->previousPageUrl() }}" class="px-3 py-2 rounded-md bg-white border text-gray-700 hover:bg-gray-50">‹</a>
        @endif

        {{-- First page + ellipsis if needed --}}
        @if($start > 1)
            <a href="{{ $p->url(1) }}" class="px-3 py-2 rounded-md bg-white border text-gray-700 hover:bg-gray-50">1</a>
            @if($start > 2)
                <span class="px-2 text-gray-400">…</span>
            @endif
        @endif

        {{-- Page window --}}
        @for($i = $start; $i <= $end; $i++)
            @if($i == $current)
                <span class="px-3 py-2 rounded-md bg-blue-600 text-white font-semibold">{{ $i }}</span>
            @else
                <a href="{{ $p->url($i) }}" class="px-3 py-2 rounded-md bg-white border text-gray-700 hover:bg-gray-50">{{ $i }}</a>
            @endif
        @endfor

        {{-- Ellipsis + last page if needed --}}
        @if($end < $last)
            @if($end < $last - 1)
                <span class="px-2 text-gray-400">…</span>
            @endif
            <a href="{{ $p->url($last) }}" class="px-3 py-2 rounded-md bg-white border text-gray-700 hover:bg-gray-50">{{ $last }}</a>
        @endif

        {{-- Next --}}
        @if($p->hasMorePages())
            <a href="{{ $p->nextPageUrl() }}" class="px-3 py-2 rounded-md bg-white border text-gray-700 hover:bg-gray-50">›</a>
        @else
            <span class="px-3 py-2 rounded-md bg-gray-200 text-gray-400">›</span>
        @endif
    </nav>

    <div class="text-sm text-gray-600">
        @if($p->total() > 0)
            Showing {{ $p->firstItem() }} to {{ $p->lastItem() }} of {{ $p->total() }} results
        @else
            No results
        @endif
    </div>
</div>
