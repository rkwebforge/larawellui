{{-- Keeps input to digits and the given decimals: 2 by default, 0 for whole numbers, or as many as you need (4 for exchange rates, 8 for crypto). Extra places are cut, not rounded. A decimal comma works too: 12,50 becomes 12.50. prefix and suffix sit inside the box; the action slot sits at the end. negative allows a leading minus. Max fills in the balance from the script beside this. --}}
<div class="grid gap-6 sm:grid-cols-2">
    <x-widget.number name="amount" label="Amount" placeholder="0.00" suffix="usdt">
        <x-slot:action>
            <button type="button" class="text-primary text-sm font-medium" data-fill-max="1250.50" aria-controls="amount">Max</button>
        </x-slot:action>
    </x-widget.number>
    <x-widget.number name="price" label="Price" placeholder="0.00" prefix="$" />
    <x-widget.number name="adjustment" label="Balance adjustment" prefix="$" value="-25.00" negative />
    <x-widget.number name="quantity" label="Quantity" placeholder="0" :decimals="0" />
    <x-widget.number name="rate" label="Exchange rate" placeholder="0.0000" :decimals="4" suffix="usd/myr" />
    <x-widget.number name="btc" label="Bitcoin" placeholder="0.00000000" :decimals="8" suffix="btc" />
</div>
