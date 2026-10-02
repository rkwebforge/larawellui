{{-- scrollable keeps the title and the footer's buttons in view while only the body scrolls, so a long form never hides its Save button. --}}
<x-widget.button data-modal-open="edit-profile">Edit profile</x-widget.button>

<x-widget.modal id="edit-profile" title="Edit profile" scrollable>
    <div class="flex flex-col gap-4">
        @foreach (['Full name', 'Display name', 'Email', 'Phone', 'Company', 'Job title', 'Website', 'Address line 1', 'Address line 2', 'City', 'State or region', 'Postal code', 'Country'] as $field)
            <label class="flex flex-col gap-1 text-sm">{{ $field }}<input type="text" class="border-line rounded-xl border px-3 py-2"></label>
        @endforeach
        <label class="flex flex-col gap-1 text-sm">Bio<textarea rows="4" class="border-line rounded-xl border px-3 py-2"></textarea></label>
    </div>
    <x-slot:footer>
        <x-widget.button variant="neutral" data-modal-close>Cancel</x-widget.button>
        <x-widget.button data-modal-close>Save</x-widget.button>
    </x-slot:footer>
</x-widget.modal>
