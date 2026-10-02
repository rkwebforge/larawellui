{{-- Inside a Livewire component an open modal stays open through every render, so a form in it shows its validation errors where they belong. Open and close it from the component with $this->dispatch('modal-open', id: 'edit-profile') and 'modal-close' (which closes a disable-close modal too: the app asked). With reset-on-close, closing it also empties the bound properties. --}}
<x-widget.button data-modal-open="edit-profile">Edit profile</x-widget.button>

<x-widget.modal id="edit-profile" title="Edit profile">
    <form id="profile-form" wire:submit="save" class="space-y-4">
        <x-widget.text-input label="Name" wire:model="name" />
        <x-widget.text-input label="Email" type="email" wire:model="email" />
    </form>

    <x-slot:footer>
        <x-widget.button variant="neutral" data-modal-close>Cancel</x-widget.button>
        <x-widget.button type="submit" form="profile-form">Save</x-widget.button>
    </x-slot:footer>
</x-widget.modal>

{{-- In the component, after saving: $this->dispatch('modal-close', id: 'edit-profile'); --}}
