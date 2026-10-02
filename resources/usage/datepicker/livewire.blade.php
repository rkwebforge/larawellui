{{-- In a Livewire component, bind with wire:model (deferred) or wire:model.live to a string property holding YYYY-MM-DD, or null: public ?string $due = null. No name is needed. The field shows the property after every render, and a date set or cleared in PHP shows too; the calendar opens on it. Validate it like any date: 'due' => ['required', 'date']. --}}
<div>
    <x-widget.datepicker label="Due date" wire:model.live="due" :max="false" />

    <x-widget.datepicker label="Date of birth" wire:model="birthday" birthday />
</div>
