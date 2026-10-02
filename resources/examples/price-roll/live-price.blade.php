{{-- Change data-value from anywhere and the digits roll to the new price, flashing green or red; here the script beside this does it. live announces changes to screen readers. --}}
<div class="flex flex-col items-start gap-4">
    <x-widget.price-roll id="btc-price" :value="64210.50" currency="USD" label="Price" live class="text-4xl font-semibold" />
    <div class="flex gap-2">
        <button type="button" class="bg-field text-foreground rounded-full px-4 py-2 text-sm font-medium" data-price-change="1375.25" aria-controls="btc-price">Price up</button>
        <button type="button" class="bg-field text-foreground rounded-full px-4 py-2 text-sm font-medium" data-price-change="-842.75" aria-controls="btc-price">Price down</button>
    </div>
</div>
