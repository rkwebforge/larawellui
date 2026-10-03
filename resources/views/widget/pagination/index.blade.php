@props([
    // Any Laravel paginator: paginate(), simplePaginate() or cursorPaginate() (the last two get the summary style, or
    // load more, since they have no page count). In Livewire, from a component using WithPagination.
    'paginator',
    // drawer (a bottom sheet of pages), numbers, segmented, jump, footer (with rows per page), summary or load-more.
    'type' => 'drawer',
    // type="footer": the sizes to offer. Declared here so they reach it: forwarded attributes keep kebab-case names.
    'perPageOptions' => [10, 25, 50, 100],
    // type="footer": the query parameter the size submits as.
    'perPageName' => 'per_page',
    // Livewire: the rows-per-page property, e.g. "perPage". type="footer" binds its select to it; type="load-more" raises
    // it by a page each time, so the component renders the longer list.
    'perPageModel' => null,
])

{{--
    Works with any Laravel paginator. summary and load-more suit ->simplePaginate() and ->cursorPaginate()
    as well; the other styles need a page count, so without one (no total) they fall back to summary.
--}}
@php
    // A typo fails loudly, naming the values that work, instead of quietly rendering something else.
    if (! in_array($type, ['drawer', 'numbers', 'segmented', 'jump', 'footer', 'summary', 'load-more'], true)) {
        throw new \InvalidArgumentException("Unknown type [{$type}] for <x-widget.pagination>. Use one of: drawer, numbers, segmented, jump, footer, summary, load-more.");
    }
    // Livewire's paginators use a relative path ("orders"): from /orders, their links would open /orders/orders.
    if (! preg_match('#^(/|[a-z][a-z0-9+.-]*:)#i', (string) $paginator->path())) {
        $paginator->withPath(url()->to((string) $paginator->path()));
    }
    // On every style's root: in a Livewire component, resources/js/widget/pagination turns its page links (and the jump
    // form) into gotoPage() calls on the component instead of page loads, and needs to know the page parameter.
    $attributes = $attributes->merge([
        'data-pagination' => '',
        'data-page-name' => $paginator instanceof \Illuminate\Contracts\Pagination\CursorPaginator ? $paginator->getCursorName() : $paginator->getPageName(),
    ]);
@endphp

@if ($paginator->hasPages())
    @if ($type === 'load-more')
        <x-widget.pagination.load-more :paginator="$paginator" :per-page-model="$perPageModel" {{ $attributes }} />
    @elseif ($type === 'summary' || ! $paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
        <x-widget.pagination.summary :paginator="$paginator" {{ $attributes }} />
    @elseif ($type === 'numbers' || $type === 'segmented')
        <x-widget.pagination.numbers :paginator="$paginator" :segmented="$type === 'segmented'" {{ $attributes }} />
    @elseif ($type === 'jump')
        <x-widget.pagination.jump :paginator="$paginator" {{ $attributes }} />
    @elseif ($type === 'footer')
        <x-widget.pagination.footer :paginator="$paginator" :per-page-options="$perPageOptions" :per-page-name="$perPageName" :per-page-model="$perPageModel" {{ $attributes }} />
    @else
        <x-widget.pagination.drawer :paginator="$paginator" {{ $attributes }} />
    @endif
@endif
