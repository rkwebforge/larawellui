{{-- Around your own control in a Livewire component: put wire:model on the control, and pass the frame the property's errors with :error, since it can't see your control's binding. Give the control a fixed id (the one the frame's label points at): Livewire's morph matches elements by id, and a changing one drops focus. --}}
<x-widget.field id="volume" label="Volume" :error="$errors->get('volume')" bare>
    <input id="volume" type="range" min="0" max="100" wire:model.live="volume" class="accent-primary h-12 w-full cursor-pointer">
</x-widget.field>
