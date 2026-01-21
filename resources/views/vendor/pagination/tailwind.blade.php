@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col items-center">
        {{-- Results Summary --}}
        <div class="mb-6">
            <p class=" text-[10px] uppercase tracking-[1.5px] opacity-50">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                    <span class="font-bold">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-bold">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-bold">{{ $paginator->total() }}</span>
                {!! __('Results') !!}
            </p>
        </div>

        {{-- Pagination Links --}}
        <div class="flex flex-wrap justify-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="w-10 h-10 flex items-center justify-center border border-gray-100 opacity-30 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="w-10 h-10 flex items-center justify-center border border-[#e2e8f0] hover:border-[#D4AF37] hover:text-[#D4AF37] transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="w-10 h-10 flex items-center justify-center  text-xs opacity-50">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center bg-[#D4AF37] text-white  text-xs">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center border border-[#e2e8f0]  text-xs hover:border-[#D4AF37] hover:text-[#D4AF37] transition-all duration-300">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="w-10 h-10 flex items-center justify-center border border-[#e2e8f0] hover:border-[#D4AF37] hover:text-[#D4AF37] transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            @else
                <span class="w-10 h-10 flex items-center justify-center border border-gray-100 opacity-30 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </span>
            @endif
        </div>
    </nav>
@endif

