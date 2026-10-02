{{-- previous is where the price started (today's open, say); the badge shows the change since then and follows the price as it rolls. change="percent" (the default), "amount" or "both". Screen readers hear it with the price: "Price: $65,585.75, up 4.38%". --}}
<div class="flex flex-col items-start gap-4">
    <x-widget.price-roll id="eth-price" :value="3218.40" :previous="3102.75" currency="USD" locale="en-US" label="Ether" change="both" live class="text-4xl font-semibold" />
    <div class="flex gap-2">
        <button type="button" class="bg-field text-foreground rounded-full px-4 py-2 text-sm font-medium" data-price-step="84.60" aria-controls="eth-price">Price up</button>
        <button type="button" class="bg-field text-foreground rounded-full px-4 py-2 text-sm font-medium" data-price-step="-131.25" aria-controls="eth-price">Price down</button>
    </div>
</div>
