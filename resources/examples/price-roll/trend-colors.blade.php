{{-- Up is good by default (green). trend-colors="inverse" is for values where up is bad, like a delivery fee or a wait; "none" drops the colours, for a total that is neither good nor bad news. --}}
<div class="grid gap-6 sm:grid-cols-3">
    <div>
        <p class="text-foreground/75 mb-1 text-sm">Portfolio</p>
        <x-widget.price-roll id="trend-default" :value="12480" :previous="12100" currency="USD" locale="en-US" :decimals="0" label="Portfolio" class="text-2xl font-semibold" />
    </div>
    <div>
        <p class="text-foreground/75 mb-1 text-sm">Delivery fee</p>
        <x-widget.price-roll id="trend-inverse" :value="6.50" :previous="4.99" currency="USD" locale="en-US" label="Delivery fee" trend-colors="inverse" change="amount" class="text-2xl font-semibold" />
    </div>
    <div>
        <p class="text-foreground/75 mb-1 text-sm">Cart total</p>
        <x-widget.price-roll id="trend-none" :value="84.20" :previous="79.90" currency="USD" locale="en-US" label="Cart total" trend-colors="none" change="amount" class="text-2xl font-semibold" />
    </div>
    <button type="button" class="bg-field text-foreground justify-self-start rounded-full px-4 py-2 text-sm font-medium sm:col-span-3" data-raise-all="trend-default trend-inverse trend-none">Raise all three</button>
</div>
