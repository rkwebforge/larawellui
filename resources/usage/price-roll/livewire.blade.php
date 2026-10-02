{{-- In a Livewire component, pass the price from a property: each render rolls the digits to the new one and updates the change badge, on wire:poll too. A price roll that arrives with a render sets itself up. --}}
<div wire:poll.5s="refreshQuote">
    <x-widget.price-roll :value="$quote->price" :previous="$quote->open" currency="USD" label="BTC" live class="text-4xl font-semibold" />
</div>
