{{-- The view for that component. Any style works as it is; per-page-model is only needed for rows per page and load more. Give each item a wire:key. --}}
<div>
    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search orders" aria-label="Search orders">

    <ul id="orders">
        @foreach ($orders as $order)
            <li wire:key="order-{{ $order->id }}">{{ $order->number }}</li>
        @endforeach
    </ul>

    {{-- Pick one. --}}
    <x-widget.pagination type="numbers" :paginator="$orders" />
    <x-widget.pagination type="footer" :paginator="$orders" per-page-model="perPage" :per-page-options="[10, 25, 50]" />
    <x-widget.pagination type="load-more" :paginator="$orders" target="#orders" per-page-model="perPage" />
</div>
