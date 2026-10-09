{{-- Inside a Livewire component, bind the checkbox look with wire:model (or wire:model.live) to an array property: public array $permissions = []. Ticking updates it, and setting it in PHP ticks the boxes after the render. Which nodes are open stays as the person left it, so :open only sets how a node starts. Children fetched with children-url stay through renders too. --}}
<div>
    <x-widget.tree label="Permissions" variant="checkbox" wire:model.live="permissions">
        @foreach ($groups as $group)
            <x-widget.tree.item wire:key="group-{{ $group->id }}" :label="$group->name" open>
                @foreach ($group->permissions as $permission)
                    <x-widget.tree.item wire:key="permission-{{ $permission->id }}" :label="$permission->label" :value="$permission->name" />
                @endforeach
            </x-widget.tree.item>
        @endforeach
    </x-widget.tree>

    <button type="button" wire:click="save">Save</button>
</div>
