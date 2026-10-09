{{-- Ctrl+K (Cmd+K on a Mac) or the button opens it. Typing filters by label and keywords, every word in any order: try "new inv". An item with href opens that page; one without is clicked, so give it wire:click or listen for the click, as the script beside this does. --}}
<x-widget.command id="palette" label="Search pages and actions">
    <x-widget.command.group label="Pages">
        <x-widget.command.item href="#dashboard" icon="home" keywords="start overview">Dashboard</x-widget.command.item>
        <x-widget.command.item href="#invoices" icon="file" keywords="billing bills">Invoices</x-widget.command.item>
        <x-widget.command.item href="#customers" icon="users" keywords="clients people">Customers</x-widget.command.item>
        <x-widget.command.item href="#settings" icon="settings" keywords="account profile preferences" shortcut="G S">Settings</x-widget.command.item>
    </x-widget.command.group>
    <x-widget.command.group label="Actions">
        <x-widget.command.item icon="plus" keywords="create add" data-palette-action="New invoice">New invoice</x-widget.command.item>
        <x-widget.command.item icon="copy" keywords="share url" data-palette-action="Link copied">Copy page link</x-widget.command.item>
    </x-widget.command.group>
</x-widget.command>

<p id="palette-action" role="status" class="text-foreground/70 mt-3 text-sm"></p>
