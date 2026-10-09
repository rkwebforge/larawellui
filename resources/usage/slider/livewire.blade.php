{{-- In a Livewire component, bind with wire:model (deferred) or wire:model.live; no name is needed. One thumb binds a number: public int $volume = 40. A range binds an array, public array $price = [200, 750], each thumb its own end (price.0 and price.1). The slider shows the property after every render, so setting it in PHP moves the thumbs. --}}
<div class="space-y-6">
    <x-widget.slider label="Volume" wire:model.live="volume" suffix="%" />

    <x-widget.slider label="Price" range wire:model="price" :max="1000" :step="10" prefix="$" />
</div>
