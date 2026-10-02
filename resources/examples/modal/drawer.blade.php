{{-- variant="drawer" slides a panel in from the end edge (side="end", the right in left-to-right pages), the start edge, or the bottom. Same focus, Esc and backdrop behaviour as a dialog; size sets its width. --}}
<div class="flex flex-wrap gap-3">
    <x-widget.button variant="neutral" data-modal-open="filters-drawer">Filters</x-widget.button>
    <x-widget.button variant="neutral" data-modal-open="share-sheet">Share</x-widget.button>
</div>

<x-widget.modal id="filters-drawer" title="Filters" variant="drawer" size="sm" close-on-backdrop>
    <div class="flex flex-col gap-3 text-sm">
        @foreach (['Deposits', 'Withdrawals', 'Transfers', 'Fees'] as $type)
            <label class="flex items-center gap-2"><input type="checkbox" checked class="accent-primary size-4"> {{ $type }}</label>
        @endforeach
    </div>
    <x-slot:footer>
        <x-widget.button variant="neutral" data-modal-close>Reset</x-widget.button>
        <x-widget.button data-modal-close>Show results</x-widget.button>
    </x-slot:footer>
</x-widget.modal>

<x-widget.modal id="share-sheet" label="Share" variant="drawer" side="bottom" close-on-backdrop>
    <p class="text-foreground/75 text-sm">A bottom sheet: the usual shape for quick actions on phones.</p>
</x-widget.modal>
