{{-- children-url: the node's children come from your app the first time it opens, with a spinner meanwhile, so a network of thousands sends only what's looked at. The URL returns them as HTML, in a tree of the same look (see the endpoint under Usage); a node whose URL returns none becomes a leaf, and one that fails offers to try again. --}}
<x-widget.tree label="Referral network" variant="cards">
    <x-widget.tree.item label="amelia.chen" meta="Level 0" :children-url="route('members.children', 1)">
        <x-slot:details>Joined 12 Jan 2026 · Team of 3</x-slot:details>
    </x-widget.tree.item>
</x-widget.tree>
