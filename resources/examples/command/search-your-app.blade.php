{{-- suggest-url asks your app as people type (GET ?q=…, JSON), with the same answer the search widget's suggestions take; its results follow the items that match. recent keeps the last five pages chosen, in this browser only, and lists them before anything is typed. trigger="false" leaves out the button: here a link opens it, with data-command-open. --}}
<x-widget.command id="product-palette" label="Search products" placeholder="Search products…" :suggest-url="route('products.suggest')" :trigger="false" shortcut="j" recent>
    <x-widget.command.group label="Browse">
        <x-widget.command.item href="#new-arrivals" icon="star">New arrivals</x-widget.command.item>
        <x-widget.command.item href="#on-sale" icon="tag" keywords="discount offers">On sale</x-widget.command.item>
    </x-widget.command.group>
</x-widget.command>

<p class="text-sm">
    <button type="button" data-command-open="product-palette" class="text-link hover:text-link-hover underline underline-offset-4">Search products</button>, or press Ctrl+J.
</p>
