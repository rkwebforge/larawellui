{{-- In a Livewire component, bind with wire:model (deferred) or wire:model.live, single or multiple. Without :value the select shows the bound property, so it keeps the choice through every render, and setting or clearing the property in PHP updates it. Options may change between renders: here the cities follow the country (reset $city in updatedCountry()). --}}
<div>
    <x-widget.select name="country" label="Country" :options="$countries" wire:model.live="country" />

    <x-widget.select name="city" label="City" placeholder="Pick a city" :options="$cities" wire:model.live="city" searchable :search-min="8" />

    <x-widget.select name="tags" label="Tags" multiple display="chips" clearable :options="$tags" wire:model="selectedTags" />

    <button type="button" wire:click="save">Save</button>
</div>
