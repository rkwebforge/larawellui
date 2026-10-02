{{-- Inside a Livewire component the open tab stays as the person left it through every render, and the panels' content updates. Bind it with wire:model to a property to know it in PHP, or to open one from PHP: public string $tab = 'profile'. Bound, the property decides which tab is open after each render. --}}
<x-widget.tabs id="account" label="Account" wire:model.live="tab" :tabs="['profile' => 'Profile', 'security' => 'Security']">
    <x-slot:profile>
        <livewire:profile-form />
    </x-slot:profile>
    <x-slot:security>
        @if ($tab === 'security')
            {{-- Only load what the open tab needs. --}}
            <livewire:sessions-list />
        @endif
    </x-slot:security>
</x-widget.tabs>
