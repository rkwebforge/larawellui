{{-- In a Livewire component, bind with wire:model; no name is needed, and the new-password checklist works the same. The password is never written into the HTML, Livewire renders included, so it can't leak into a page snapshot. Clear the property after saving ($this->reset('password', 'password_confirmation')), so it isn't kept in the component's state. --}}
<form wire:submit="updatePassword" class="space-y-5">
    <x-widget.password label="Current password" wire:model="current_password" />

    <x-widget.password label="New password" new :min="8" numbers symbols wire:model="password" />

    <x-widget.password label="Confirm password" wire:model="password_confirmation" autocomplete="new-password" />

    <button type="submit">Update password</button>
</form>
