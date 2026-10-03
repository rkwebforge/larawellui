@props([
    // A length-aware paginator (paginate()).
    'paginator',
])

@php
    $pageName = $paginator->getPageName();
    $inputId = app(\LarawellUi\Support\ElementIds::class)->claim('goto-'.$pageName);

    // Carry over whatever query the paginator's own links carry (filters, appends(), withQueryString()).
    parse_str(parse_url($paginator->url(1), PHP_URL_QUERY) ?? '', $query);
    unset($query[$pageName]);
    $hidden = collect(\Illuminate\Support\Arr::dot($query))
        ->filter(fn (mixed $value): bool => is_scalar($value))
        // Arr::dot gives "filter.status"; a form field needs "filter[status]".
        ->mapWithKeys(fn (mixed $value, string $key): array => [preg_replace('/\.([^.]+)/', '[$1]', $key) => $value]);
@endphp

<div {{ $attributes->class(['flex flex-wrap items-center justify-center gap-x-4 gap-y-3 px-0 py-5 sm:justify-between sm:p-5']) }}>
    {{-- A plain GET form, so it works without JS. Out-of-range input is blocked by min/max. --}}
    {{-- The #fragment survives a GET submit, so the jump lands on the table like the links do. --}}
    <form method="GET" action="{{ $paginator->path() }}{{ $paginator->fragment() ? '#'.$paginator->fragment() : '' }}" class="flex items-center gap-2">
        @foreach ($hidden as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach

        <label for="{{ $inputId }}" class="sr-only">Go to page</label>
        <input
            type="number"
            id="{{ $inputId }}"
            name="{{ $pageName }}"
            min="1"
            max="{{ $paginator->lastPage() }}"
            required
            placeholder="{{ $paginator->currentPage() }}"
            class="bg-field border-line hover:border-primary focus:border-primary placeholder:text-muted h-8 w-16 rounded border px-2 text-sm outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none"
        >
        <x-widget.button type="submit" size="sm" aria-label="Go to page" class="h-8 px-2!"><x-widget.icon name="arrow-right" class="size-5" /></x-widget.button>
    </form>

    <nav aria-label="Pagination" class="flex items-center gap-1">
        <x-widget.button size="sm" :href="$paginator->previousPageUrl()" :disabled="$paginator->onFirstPage()" rel="prev" aria-label="Previous page" class="p-1!"><x-widget.icon name="chevron-left" class="size-5" /></x-widget.button>
        <span class="px-1 text-sm tabular-nums" aria-current="page">{{ $paginator->currentPage() }} / {{ number_format($paginator->lastPage()) }}</span>
        <x-widget.button size="sm" :href="$paginator->nextPageUrl()" :disabled="! $paginator->hasMorePages()" rel="next" aria-label="Next page" class="p-1!"><x-widget.icon name="chevron-right" class="size-5" /></x-widget.button>
    </nav>
</div>
