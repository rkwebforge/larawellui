{{-- Any element with data-modal-open="{id}" opens it; data-modal-close closes it. From JS: modal.open(id), modal.close(id). mobile="sheet" turns it into a bottom sheet on phones. --}}
<x-widget.button data-modal-open="delete-transaction">Delete transaction</x-widget.button>

<x-widget.modal id="delete-transaction" title="Delete transaction?" close-on-backdrop size="sm" mobile="sheet">
    <p class="text-foreground/75 text-sm">This can't be undone. Click outside, press Esc or use a button to close.</p>
    <x-slot:footer>
        <x-widget.button variant="neutral" data-modal-close>Cancel</x-widget.button>
        <x-widget.button variant="danger" data-modal-close>Delete</x-widget.button>
    </x-slot:footer>
</x-widget.modal>
