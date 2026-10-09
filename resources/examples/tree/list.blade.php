{{-- The default look: compact rows under indent guides, like a file explorer. open starts a node open, meta adds a count at the end of the row, and href makes a node a link. The arrow keys move through it: Right opens, Left closes or goes up a level. --}}
<x-widget.tree label="Files" class="max-w-sm">
    <x-widget.tree.item label="Documents" icon="inbox" meta="3" open>
        <x-widget.tree.item label="Invoices" icon="inbox" meta="2">
            <x-widget.tree.item label="March.pdf" icon="file" href="#invoice-march" />
            <x-widget.tree.item label="April.pdf" icon="file" href="#invoice-april" />
        </x-widget.tree.item>
        <x-widget.tree.item label="Lease.pdf" icon="file" href="#lease" />
        <x-widget.tree.item label="Tax return.pdf" icon="file" href="#tax-return" />
    </x-widget.tree.item>
    <x-widget.tree.item label="Photos" icon="image" meta="2">
        <x-widget.tree.item label="Beach.jpg" icon="image" />
        <x-widget.tree.item label="Garden.jpg" icon="image" />
    </x-widget.tree.item>
    <x-widget.tree.item label="Notes.txt" icon="file" />
</x-widget.tree>
