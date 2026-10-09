{{-- Inside a Livewire component, an item without href takes wire:click: choosing it by Enter or a click runs the action and closes the palette. Open it from the component with $this->dispatch('command-open', id: 'palette'). --}}
<x-widget.command id="palette" label="Search pages and actions">
    <x-widget.command.item wire:click="archiveAll" icon="inbox">Archive all read</x-widget.command.item>
    <x-widget.command.item href="/settings" icon="settings">Settings</x-widget.command.item>
</x-widget.command>
