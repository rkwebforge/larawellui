{{-- In a Livewire component, bind with wire:model (deferred) or wire:model.live; no name is needed. The property always gets the plain number (1234.5), even with grouped showing 1,234.50 or a decimal comma typed in, and the stepper's -/+ update it too. The field shows the property after every render, so setting it in PHP updates both. Keep it a string or a float: public ?string $amount = null. --}}
<div class="space-y-5">
    <x-widget.number label="Amount" grouped suffix="USD" wire:model.live="amount" />

    <x-widget.number label="Seats" stepper :decimals="0" min="1" max="20" wire:model.live="seats" />
</div>
