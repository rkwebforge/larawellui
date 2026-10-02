{{-- Formatting follows the locale, on the server and in the browser. currency=false formats a plain number. Without currency it uses config('app.currency'). --}}
<div class="flex flex-wrap items-baseline gap-8">
    <x-widget.price-roll :value="1234567.5" currency="INR" locale="en-IN" class="text-2xl" />
    <x-widget.price-roll :value="999" currency="EUR" locale="de-DE" :decimals="0" class="text-2xl" />
    <x-widget.price-roll :value="1284" :currency="false" class="text-2xl" />
</div>
