{{-- Four tones, each with its own icon, so colour is never the only signal. The title is optional. --}}
<div class="grid max-w-2xl gap-3">
    <x-widget.alert>Exports run overnight and are ready by 6am.</x-widget.alert>
    <x-widget.alert tone="success" title="Payment received">We've emailed a receipt to ana@example.com.</x-widget.alert>
    <x-widget.alert tone="warning" title="Your trial ends in 3 days">Add a card to keep your projects running.</x-widget.alert>
    <x-widget.alert tone="error" title="Payout failed">The bank rejected the transfer. Check the account details and try again.</x-widget.alert>
</div>
