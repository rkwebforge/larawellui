{{-- A wizard in one Livewire component: pass the current step from a property and the stepper follows it on every render, the dots and bars too. A step's href is a link, so in a single-page wizard leave it out and give the step buttons of your own their wire:click. --}}
<div class="space-y-6">
    <x-widget.stepper.labelled label="Checkout" :current="$step" :steps="['Cart', 'Address', 'Payment', 'Review']" />

    {{-- the current step's fields --}}

    <div class="flex justify-between">
        <x-widget.button variant="neutral" wire:click="back" :disabled="$step === 1">Back</x-widget.button>
        <x-widget.button wire:click="next">Continue</x-widget.button>
    </div>
</div>
