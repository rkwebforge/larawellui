{{-- Every input binds with wire:model (deferred) or wire:model.live, and a name isn't needed: the property names the field, its id stays the same on every render (so typing keeps focus) and $errors are read under it. Without :value a field shows the bound property, so setting or clearing it in PHP updates the field, the grouped number's display, the phone's country and the OTP boxes included. The password is never rendered back, Livewire included. In Livewire an error stays until the component validates again; call $this->validateOnly($property) in updated() to clear it as people type. --}}
<form wire:submit="save" class="space-y-5">
    <x-widget.text-input label="Name" wire:model.live="name" counter maxlength="60" />
    <x-widget.text-input label="Email" type="email" wire:model="email" />
    <x-widget.password label="Password" new :min="8" numbers wire:model="password" />
    <x-widget.number label="Amount" grouped wire:model.live="amount" suffix="USD" />
    <x-widget.number label="Seats" stepper :decimals="0" min="1" max="20" wire:model.live="seats" />
    <x-widget.phone label="Phone" country="US" wire:model="phone" />
    <x-widget.textarea label="Notes" counter maxlength="500" wire:model="notes" />
    <x-widget.radio label="Plan" :options="['free' => 'Free', 'pro' => 'Pro']" wire:model.live="plan" />
    <x-widget.checkbox label="I agree to the terms" wire:model="agree" />
    <x-widget.switch label="Email me updates" wire:model="updates" />
    <x-widget.otp label="Code we sent you" :length="6" wire:model="otp" />

    <button type="submit">Save</button>
</form>
