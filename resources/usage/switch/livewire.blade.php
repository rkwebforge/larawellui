{{-- In a Livewire component, bind a bool with wire:model (deferred) or wire:model.live: public bool $updates = false. No name is needed. With .live each flip reaches the server at once, so a settings page can save it in updatedUpdates() with no Save button. The switch shows the property after every render, so turning it on or off in PHP flips it. --}}
<div class="space-y-4">
    <x-widget.switch label="Email me updates" wire:model.live="updates" />

    <x-widget.switch label="Dark mode" description="Follows your system until you choose." wire:model="darkMode" />
</div>
