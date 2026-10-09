{{-- With only a label, the trigger is an icon button. The panel takes anything; text alone gets focus itself, so screen readers read it from the top. Esc, a click outside or Tab closes it, and focus goes back to the button. For a menu of actions, use the dropdown. --}}
<p class="flex items-center gap-2 text-sm">
    Transfer fee: $1.50
    <x-widget.popover label="About the transfer fee" size="sm" variant="tertiary">
        <p>A flat fee for each transfer, whatever the amount. Transfers between your own wallets are free.</p>
    </x-widget.popover>
</p>
