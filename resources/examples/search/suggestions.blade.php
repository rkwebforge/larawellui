{{-- suggest-url lists suggestions as you type, after two characters (suggest-min). The arrow keys move through them and Enter takes one, filling the box; in a form, it then searches. Try "wire" or "desk". --}}
<x-widget.search name="q" placeholder="Search products" class="max-w-md" suggest-url="{{ route('products.suggest') }}" />
