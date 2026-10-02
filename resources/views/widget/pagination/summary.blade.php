@props(['paginator'])

@php
    // Cursor paginators have no item numbers, so they get the buttons alone.
    $from = method_exists($paginator, 'firstItem') ? $paginator->firstItem() : null;
    $to = method_exists($paginator, 'lastItem') ? $paginator->lastItem() : null;
    $total = $paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $paginator->total() : null;
@endphp

<nav aria-label="Pagination" {{ $attributes->class(['flex flex-col items-center gap-3 px-0 py-5 sm:flex-row sm:justify-between sm:p-5']) }}>
    @if ($from !== null)
        <p class="text-foreground/75 text-sm tabular-nums">
            Showing <span class="text-foreground font-medium">{{ number_format($from) }}</span>
            to <span class="text-foreground font-medium">{{ number_format($to) }}</span>
            @if ($total !== null) of <span class="text-foreground font-medium">{{ number_format($total) }}</span> results @endif
        </p>
    @endif

    <div @class(['flex gap-2', 'sm:ms-auto' => $from === null])>
        <x-widget.button variant="neutral" size="sm" :href="$paginator->previousPageUrl()" :disabled="$paginator->onFirstPage()" icon-start="chevron-left" rel="prev">Previous</x-widget.button>
        <x-widget.button variant="neutral" size="sm" :href="$paginator->nextPageUrl()" :disabled="! $paginator->hasMorePages()" icon-end="chevron-right" rel="next">Next</x-widget.button>
    </div>
</nav>
