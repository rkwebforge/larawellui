{{-- Inside a Livewire component, a render updates what's in each panel and leaves it open or shut as the person left it, the closing animation and the one-at-a-time group included. So :open only sets how a panel starts; changing it in PHP later doesn't open or close it. In a menu, the group someone opened and the #section link they clicked stay as they were too. Give panels built in a loop a wire:key. --}}
<div class="flex flex-col gap-2">
    @foreach ($orders as $order)
        <x-widget.accordion wire:key="order-{{ $order->id }}" name="orders" :title="'Order '.$order->number">
            {{ $order->status }}: {{ $order->total }}

            <button type="button" wire:click="refund({{ $order->id }})">Refund</button>
        </x-widget.accordion>
    @endforeach
</div>
