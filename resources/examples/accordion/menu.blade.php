{{-- variant="menu" inside <x-widget.accordion.menu>: a sidebar that scrolls on its own and opens already scrolled to the current page, with no flash of the top of the list first. Groups start open; :open="false" closes one. With #section links like these, the highlight follows the link you click and the URL's #hash. --}}
<x-widget.accordion.menu label="Documentation" class="max-h-72 max-w-64">
    <x-widget.accordion.menu-item href="#introduction">Introduction</x-widget.accordion.menu-item>
    <x-widget.accordion.menu-item href="#installation">Installation</x-widget.accordion.menu-item>

    <x-widget.accordion variant="menu" title="Getting started">
        <x-widget.accordion.menu-item href="#first-steps">First steps</x-widget.accordion.menu-item>
        <x-widget.accordion.menu-item href="#configuration">Configuration</x-widget.accordion.menu-item>
        <x-widget.accordion.menu-item href="#directory-structure">Directory structure</x-widget.accordion.menu-item>
    </x-widget.accordion>

    <x-widget.accordion variant="menu" title="Billing">
        <x-widget.accordion.menu-item href="#plans">Plans</x-widget.accordion.menu-item>
        <x-widget.accordion.menu-item href="#invoices">Invoices</x-widget.accordion.menu-item>
        <x-widget.accordion.menu-item href="#refunds" current>Refunds</x-widget.accordion.menu-item>
        <x-widget.accordion.menu-item href="#tax">Tax</x-widget.accordion.menu-item>
    </x-widget.accordion>

    <x-widget.accordion variant="menu" title="Account" :open="false">
        <x-widget.accordion.menu-item href="#profile">Profile</x-widget.accordion.menu-item>
        <x-widget.accordion.menu-item href="#security">Security</x-widget.accordion.menu-item>
    </x-widget.accordion>

    <x-widget.accordion.menu-item href="#changelog">Changelog</x-widget.accordion.menu-item>
</x-widget.accordion.menu>
