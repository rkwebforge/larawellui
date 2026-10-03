{{-- A suggestion can carry small text at the end (meta): a category, a price, a count. The typed text is shown in bold. Try "key". --}}
<x-widget.search name="q" placeholder="Search products" class="max-w-md" suggest-url="{{ route('products.suggest', ['style' => 'details']) }}" />
