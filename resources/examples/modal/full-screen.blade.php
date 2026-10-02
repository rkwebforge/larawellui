{{-- size="full" fills the screen, for editors and step-by-step flows. Its title and footer stay pinned. --}}
<x-widget.button variant="neutral" data-modal-open="compose">Compose</x-widget.button>

<x-widget.modal id="compose" title="New message" size="full">
    <textarea rows="12" placeholder="Write your message..." class="border-line h-full min-h-60 w-full rounded-xl border p-3 text-sm"></textarea>
    <x-slot:footer>
        <x-widget.button variant="neutral" data-modal-close>Discard</x-widget.button>
        <x-widget.button data-modal-close>Send</x-widget.button>
    </x-slot:footer>
</x-widget.modal>
