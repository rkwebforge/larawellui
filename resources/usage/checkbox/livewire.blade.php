{{-- In a Livewire component, bind with wire:model (deferred) or wire:model.live; no name is needed. One box binds a bool: public bool $terms = false. Several boxes on the same array property each add their value to it: public array $channels = ['email']. The boxes show the property after every render, so ticking or clearing it in PHP updates them. Errors are read under the property, channels.* included. --}}
<div class="space-y-5">
    <x-widget.checkbox label="I agree to the terms" wire:model="terms" />

    <div class="space-y-2">
        <x-widget.checkbox label="Email" value="email" wire:model.live="channels" />
        <x-widget.checkbox label="SMS" value="sms" wire:model.live="channels" />
        <x-widget.checkbox label="Push" value="push" wire:model.live="channels" />
    </div>
</div>
