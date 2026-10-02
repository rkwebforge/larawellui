{{-- prefix, suffix and a leading icon sit inside the box. required marks the label; the input's own required attribute is what browsers and screen readers use. --}}
<div class="grid gap-6 sm:grid-cols-2">
    <x-widget.text-input name="website" type="url" label="Website" prefix="https://" placeholder="example.com" />
    <x-widget.text-input name="weight" label="Weight" suffix="kg" placeholder="0" inputmode="decimal" />
    <x-widget.text-input name="wallet_name" label="Wallet name" icon="wallet" placeholder="Savings" required />
    <x-widget.text-input name="handle" label="Username" prefix="@" placeholder="jane" required />
</div>
