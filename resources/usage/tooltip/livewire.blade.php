{{-- Inside a Livewire component a tooltip's text updates with each render, and it stays linked to its element for screen readers. Wrap the element, not the component's root. --}}
<x-widget.tooltip :text="$synced ? 'Synced '.$syncedAt->diffForHumans() : 'Not synced yet'">
    <x-widget.button variant="neutral" icon="refresh-cw" label="Sync now" wire:click="sync" />
</x-widget.tooltip>
