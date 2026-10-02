{{-- remember keeps a menu where it was scrolled from page to page, so the link you click stays under the pointer: the menu is put back before the next page is painted, and the current item is only centred when it would otherwise be out of view. That takes a small inline script, which carries your CSP nonce if you set one with Vite::useCspNonce(); under a CSP that blocks it, the menu still opens with the current item centred. Give each menu its own key ("docs" here), or write just remember to use its label. --}}
<x-widget.accordion.menu label="Documentation" remember="docs" class="max-h-[calc(100dvh-8rem)]">
    <x-widget.accordion.menu-item href="{{ route('docs.intro') }}" :current="request()->routeIs('docs.intro')">Introduction</x-widget.accordion.menu-item>

    <x-widget.accordion variant="menu" title="Billing">
        <x-widget.accordion.menu-item href="{{ route('docs.refunds') }}" :current="request()->routeIs('docs.refunds')">Refunds</x-widget.accordion.menu-item>
    </x-widget.accordion>
</x-widget.accordion.menu>
