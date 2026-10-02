{{-- In a Livewire component, bind the group with wire:model (deferred) or wire:model.live: public string $plan = 'free'. No name is needed. The chosen option follows the property after every render, so setting it in PHP changes the choice. The values are strings in the HTML: bind an enum property (public Plan $plan) and Livewire casts it back. --}}
<x-widget.radio
    label="Plan"
    :options="['free' => 'Free', 'pro' => 'Pro', 'team' => 'Team']"
    wire:model.live="plan"
/>
