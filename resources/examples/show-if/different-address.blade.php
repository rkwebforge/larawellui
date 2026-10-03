{{-- With no value, any value shows it: here, the box being ticked. Show-ifs nest, and an inner one hides with its outer. --}}
<form class="grid max-w-sm gap-6">
    <x-widget.checkbox name="ship_elsewhere" label="Ship to a different address" />
    <x-widget.show-if field="ship_elsewhere" class="grid gap-6">
        <x-widget.text-input name="shipping[street]" label="Street" autocomplete="shipping street-address" required />
        <x-widget.checkbox name="shipping[gift]" label="It's a gift" />
        <x-widget.show-if field="shipping[gift]">
            <x-widget.textarea name="shipping[gift_message]" label="Gift message" />
        </x-widget.show-if>
    </x-widget.show-if>
</form>
