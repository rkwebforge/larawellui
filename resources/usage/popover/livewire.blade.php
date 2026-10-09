{{-- Inside a Livewire component, an open popover stays open through every render, with focus where it was, so wire:click and wire:model inside it work as anywhere else. Open and close it from the component with $this->dispatch('popover-open', id: 'filters') and 'popover-close', using the trigger's id. --}}
<x-widget.popover id="filters" trigger="Filters" title="Filters">
    <x-widget.button wire:click="clearFilters" size="sm" variant="neutral">Clear filters</x-widget.button>
</x-widget.popover>
