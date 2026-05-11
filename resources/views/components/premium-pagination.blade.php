@if ($paginator->hasPages())
    <nav class="flex justify-between items-center w-full mt-8 border-t-2 border-border pt-4">
        {{-- Shows X rows info --}}
        <div class="text-sm font-black uppercase text-accent">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} rows
        </div>

        {{-- Pagination Elements --}}
        <ul class="flex gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="action-select-premium opacity-50 cursor-not-allowed px-4 py-2 text-accent font-black" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="action-select-premium hover:text-accent px-4 py-2 transition-colors text-accent font-black" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements Logic --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                
                $elements = [];
                if ($lastPage <= 5) {
                    for ($i = 1; $i <= $lastPage; $i++) {
                        $elements[] = $i;
                    }
                } else {
                    if ($currentPage <= 4) {
                        $elements = [1, 2, 3, 4, '...'];
                    } else if ($currentPage > 4 && $currentPage < $lastPage - 1) {
                        $elements = ['...', $currentPage - 3, $currentPage - 2, $currentPage - 1, $currentPage, '...'];
                    } else {
                        $elements = ['...', $lastPage - 4, $lastPage - 3, $lastPage - 2, $lastPage - 1, $lastPage];
                    }
                }
            @endphp
            
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span class="px-4 py-2 text-accent font-black cursor-default">{{ $element }}</span></li>
                @endif

                @if (is_int($element))
                    @if ($element == $paginator->currentPage())
                        <li class="active" aria-current="page"><span class="action-select-premium bg-accent text-white px-4 py-2 border-accent shadow-[4px_4px_0_var(--color-accent)] cursor-default font-black">{{ $element }}</span></li>
                    @else
                        <li><a href="{{ $paginator->url($element) }}" class="action-select-premium text-accent hover:bg-accent hover:text-white px-4 py-2 transition-colors font-black">{{ $element }}</a></li>
                    @endif
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="action-select-premium hover:text-accent px-4 py-2 transition-colors text-accent font-black" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="action-select-premium opacity-50 cursor-not-allowed px-4 py-2 text-accent font-black" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@else
    <nav class="flex justify-between items-center w-full mt-8 border-t-2 border-border pt-4">
        <div class="text-sm font-black uppercase text-accent">
            Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} rows
        </div>
    </nav>
@endif
