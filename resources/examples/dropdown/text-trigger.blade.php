{{-- A text trigger gets a chevron, and takes the button's variant and size. Here the items are links that keep the page's other query parameters. align="end" lines the menu up with the trigger's end edge; either way it flips above when there's no room below. A disabled item stays in view but can't be chosen, and the arrow keys skip it. --}}
<div class="flex flex-wrap items-center gap-3">
    <x-widget.dropdown trigger="Export" variant="secondary">
        <x-widget.dropdown.item :href="request()->fullUrlWithQuery(['export' => 'csv'])">CSV</x-widget.dropdown.item>
        <x-widget.dropdown.item :href="request()->fullUrlWithQuery(['export' => 'xlsx'])">Excel</x-widget.dropdown.item>
        <x-widget.dropdown.item disabled>PDF (on the Pro plan)</x-widget.dropdown.item>
    </x-widget.dropdown>

    <x-widget.dropdown trigger="Sort" align="end" size="sm">
        <x-widget.dropdown.item :href="request()->fullUrlWithQuery(['sort' => 'newest'])">Newest first</x-widget.dropdown.item>
        <x-widget.dropdown.item :href="request()->fullUrlWithQuery(['sort' => 'oldest'])">Oldest first</x-widget.dropdown.item>
        <x-widget.dropdown.item :href="request()->fullUrlWithQuery(['sort' => 'amount'])">Largest amount</x-widget.dropdown.item>
    </x-widget.dropdown>
</div>
