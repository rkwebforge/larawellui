{{-- Suggestions with a group are listed under its heading, in the order the groups first appear. Try "wireless". --}}
<x-widget.search name="q" placeholder="Search products" class="max-w-md" suggest-url="{{ route('products.suggest', ['style' => 'grouped']) }}" />
