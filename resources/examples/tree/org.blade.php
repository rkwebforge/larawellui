{{-- variant="org": top-down, each parent centred over its children, like an org chart. On a narrow screen it scrolls sideways inside itself. --}}
<x-widget.tree label="Company" variant="org">
    <x-widget.tree.item label="Maya Patel" open>
        <x-slot:details>Chief Executive</x-slot:details>
        <x-widget.tree.item label="Leo Grant" open>
            <x-slot:details>Engineering</x-slot:details>
            <x-widget.tree.item label="Ivy Tran">
                <x-slot:details>Platform</x-slot:details>
            </x-widget.tree.item>
            <x-widget.tree.item label="Omar Said">
                <x-slot:details>Mobile</x-slot:details>
            </x-widget.tree.item>
        </x-widget.tree.item>
        <x-widget.tree.item label="Nora Field">
            <x-slot:details>Finance</x-slot:details>
        </x-widget.tree.item>
        <x-widget.tree.item label="Sam Ito" open>
            <x-slot:details>Operations</x-slot:details>
            <x-widget.tree.item label="Ana Costa">
                <x-slot:details>Support</x-slot:details>
            </x-widget.tree.item>
        </x-widget.tree.item>
    </x-widget.tree.item>
</x-widget.tree>
