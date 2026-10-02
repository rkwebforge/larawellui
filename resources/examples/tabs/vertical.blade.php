{{-- variant="vertical": tabs stacked beside the panel, for settings pages. The arrow keys go up and down. --}}
<x-widget.tabs id="settings" label="Settings" variant="vertical" :tabs="['general' => 'General', 'team' => 'Team', 'billing' => 'Billing', 'api' => 'API keys']">
    <x-slot:general>Workspace name, language and time zone.</x-slot:general>
    <x-slot:team>Who's in the workspace, and what they can do.</x-slot:team>
    <x-slot:billing>Plan, invoices and payment method.</x-slot:billing>
    <x-slot name="api">Keys for the API, and when each was last used.</x-slot>
</x-widget.tabs>
