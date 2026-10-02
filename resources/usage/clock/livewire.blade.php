{{-- Inside a Livewire component the clocks keep ticking through every render, and world clocks keep their offsets from the visitor. A countdown follows its :to, so moving the deadline in PHP moves it. A stopwatch or timer is the browser's alone and keeps running through renders; its props are read once, when it first appears, so give it a wire:key that changes to start a new one. Listen for clock:finished to call the component when a countdown or timer reaches zero. --}}
<div x-on:clock:finished="$wire.timeUp()" class="space-y-6">
    <x-widget.clock :timezone="$user->timezone" seconds date />

    <x-widget.clock.countdown :to="$auction->ends_at" label="Bidding closes in" />

    <x-widget.clock.stopwatch mode="timer" :duration="$round->seconds" wire:key="round-{{ $round->id }}" />
</div>
