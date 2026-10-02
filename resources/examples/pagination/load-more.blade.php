{{-- Appends the next page to the list in place, without leaving the page. target is the list's selector, and each item must be a direct child of it. Without JavaScript it's a link to the next page. Works with paginate(), simplePaginate() and cursorPaginate(); pass e.g. Order::query()->latest()->paginate(5) from your controller. In a Livewire component, add per-page-model="perPage": the component then renders the longer list itself (see Usage). --}}
<div class="w-full max-w-md">
    <ul id="order-list" class="bg-surface border-line divide-line divide-y rounded-xl border">
        @foreach ($orders as $order)
            <li class="flex items-center justify-between px-4 py-3 text-sm">
                <span class="font-medium">{{ $order['number'] }}</span>
                <span class="text-foreground/75 tabular-nums">{{ $order['total'] }}</span>
            </li>
        @endforeach
    </ul>

    <x-widget.pagination type="load-more" :paginator="$orders" target="#order-list" />
</div>
