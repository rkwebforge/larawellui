{{-- variant="cards": each node a card, joined to its children by lines, like a referral network. The details slot holds the card's figures and meta its level. Deep trees scroll sideways inside themselves rather than widen the page. --}}
<x-widget.tree label="Referral network" variant="cards">
    <x-widget.tree.item label="amelia.chen" meta="Level 0" open>
        <x-slot:details>Joined 12 Jan 2026 · Team of 5</x-slot:details>
        <x-widget.tree.item label="ben.okafor" meta="Level 1" open>
            <x-slot:details>Joined 3 Feb 2026 · Team of 2</x-slot:details>
            <x-widget.tree.item label="chloe.martin" meta="Level 2">
                <x-slot:details>Joined 19 Mar 2026 · No team yet</x-slot:details>
            </x-widget.tree.item>
            <x-widget.tree.item label="daniel.ruiz" meta="Level 2">
                <x-slot:details>Joined 2 Apr 2026 · No team yet</x-slot:details>
            </x-widget.tree.item>
        </x-widget.tree.item>
        <x-widget.tree.item label="erin.walsh" meta="Level 1">
            <x-slot:details>Joined 28 Feb 2026 · Team of 1</x-slot:details>
            <x-widget.tree.item label="farid.haddad" meta="Level 2">
                <x-slot:details>Joined 7 May 2026 · No team yet</x-slot:details>
            </x-widget.tree.item>
        </x-widget.tree.item>
    </x-widget.tree.item>
</x-widget.tree>
