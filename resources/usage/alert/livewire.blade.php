{{-- Inside a Livewire component: a render updates an alert's text and tone in place. A dismissed one stays hidden through later renders while it says the same thing, and shows again when its message changes. flash="status" picks up session()->flash('status', …) from an action and reads it out like after a redirect. After a failed wire:submit the error summary gets focus, as after an ordinary form, though never while someone is typing, so validateOnly() in updated() can't pull them out of a field. --}}
<form wire:submit="save" class="space-y-5">
    <x-widget.alert flash="status" tone="success" />

    <x-widget.alert.errors />

    <x-widget.text-input label="Name" wire:model="name" />
    <x-widget.text-input label="Email" type="email" wire:model="email" />

    <button type="submit">Save</button>
</form>
