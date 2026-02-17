@if ($paginator->hasPages())
    <div class="w-full border-t border-[#cfd7e7] dark:border-gray-800">
        <div id="paginationInfo"
             class="px-6 py-4 flex flex-wrap gap-3 items-center justify-between w-full">

            {{-- Texto informativo --}}
            <p class="text-xs text-[#4c669a] dark:text-gray-400">
                Mostrando {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }}
                de {{ $paginator->total() }} registros
            </p>

            {{-- Botones --}}
            <div class="flex gap-1">
                {{-- Anterior --}}
                @if ($paginator->onFirstPage())
                    <span class="size-8 flex items-center justify-center rounded border opacity-50 pointer-events-none">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="size-8 flex items-center justify-center rounded border">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </a>
                @endif

                {{-- Páginas --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="size-8 flex items-center justify-center rounded border opacity-50">
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <a href="{{ $url }}"
                               class="size-8 flex items-center justify-center rounded text-xs font-bold
                               {{ $page == $paginator->currentPage() ? 'bg-primary text-white' : 'border' }}">
                                {{ $page }}
                            </a>
                        @endforeach
                    @endif
                @endforeach

                {{-- Siguiente --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="size-8 flex items-center justify-center rounded border">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </a>
                @else
                    <span class="size-8 flex items-center justify-center rounded border opacity-50 pointer-events-none">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </span>
                @endif
            </div>
        </div>
    </div>
@endif
