@props(['paginator'])

@if ($paginator && $paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-center">
        <ul class="inline-flex items-center -space-x-px" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li aria-disabled="true">
                            <span class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm text-gray-500">&lt;</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-50" aria-label="Previous">&lt;</a>
                        </li>
                    @endif

                    {{-- Numeric Links: window of 2 on each side --}}
                    @php
                        $current = $paginator->currentPage();
                        $last = $paginator->lastPage();
                        $start = max(1, $current - 2);
                        $end = min($last, $current + 2);
                    @endphp

                    @if($start > 1)
                        <li>
                            <a href="{{ $paginator->url(1) }}" class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-50">1</a>
                        </li>
                        @if($start > 2)
                            <li class="px-2">…</li>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $current)
                            <li aria-current="page">
                                <span class="relative inline-flex items-center px-3 py-2 border border-indigo-600 bg-indigo-50 text-sm text-indigo-700">{{ $i }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $paginator->url($i) }}" class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-50">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor

                    @if($end < $last)
                        @if($end < $last - 1)
                            <li class="px-2">…</li>
                        @endif
                        <li>
                            <a href="{{ $paginator->url($last) }}" class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-50">{{ $last }}</a>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-50" aria-label="Next">&gt;</a>
                        </li>
                    @else
                        <li aria-disabled="true">
                            <span class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm text-gray-500">&gt;</span>
                        </li>
                    @endif
        </ul>
    </nav>
@endif
