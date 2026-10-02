{{-- In a Livewire component, bind with wire:model; no name is needed. The boxes fill one hidden input, and that's what's bound, so the property holds the whole code (123456). When the last box is filled the component fires otp-complete, which Alpine (bundled with Livewire) can hand to a method: no Verify button needed. Set the property to '' in PHP, after a wrong code, and the boxes empty. --}}
<div x-on:otp-complete="$wire.verify()">
    <x-widget.otp label="Code we sent you" :length="6" wire:model="code" />
</div>
