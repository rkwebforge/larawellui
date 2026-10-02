{{-- disable-close turns off Esc, the backdrop and the close button; only modal.close(id, { force: true }) closes it, from your own script. --}}
<x-widget.button data-modal-open="accept-terms">Review terms</x-widget.button>

<x-widget.modal id="accept-terms" title="Accept the terms" disable-close>
    <p class="text-foreground/75 text-sm">Esc, the backdrop and the close button are disabled. Only the button below closes this.</p>
    <x-slot:footer>
        <x-widget.button data-accept-terms>I accept</x-widget.button>
    </x-slot:footer>
</x-widget.modal>
