{{-- A suggestion with an href opens that page when chosen, instead of searching: a store's product, a docs article. Try "phone". --}}
<x-widget.search name="q" placeholder="Search products" class="max-w-md" suggest-url="{{ route('products.suggest', ['style' => 'links']) }}" />
