{{-- In a Livewire component, bind with wire:model (deferred) or wire:model.live to a string property holding HH:MM, or null: public ?string $start = null. No name is needed. Every variant shows the property after every render, so a time set or cleared in PHP shows too, and its errors are read under the property. Validate it as a time: 'start' => ['required', 'date_format:H:i']. --}}
<form wire:submit="book" class="space-y-5">
    <x-widget.time-picker label="Start" wire:model.live="start" min="08:00" max="18:00" :step="30" />

    <x-widget.time-picker label="Reminder" variant="segmented" wire:model="reminder" />

    <x-widget.time-picker label="Slot" variant="slots" :slots="$freeSlots" wire:model="slot" />

    <button type="submit">Book</button>
</form>
