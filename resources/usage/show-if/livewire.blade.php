{{-- In a Livewire component it follows the field the same way and keeps up with renders. Bind the field, and pass the starting state from the property, since there's no old input. A plain @if with wire:model.live works too, and asks the server each time. --}}
<x-widget.radio name="contact" wire:model="contact" label="How should we contact you?" inline :options="['email' => 'Email', 'phone' => 'Phone']" />
<x-widget.show-if field="contact" value="phone" :shown="$contact === 'phone'">
    <x-widget.phone name="phone" wire:model="phone" label="Phone number" />
</x-widget.show-if>
