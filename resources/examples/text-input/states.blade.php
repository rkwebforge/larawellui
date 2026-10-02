{{-- The error clears the moment the user edits the field. --}}
<div class="grid gap-6 sm:grid-cols-3">
    <x-widget.text-input name="display_name" label="With error" value="x" error="Name must be at least 2 characters." />
    <x-widget.text-input name="account_id" label="Read-only" value="ACC-20931" readonly />
    <x-widget.text-input name="referral" label="Disabled" placeholder="Not editable" disabled />
</div>
