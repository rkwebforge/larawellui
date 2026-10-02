{{-- The error clears the moment the user edits the code. --}}
<div class="grid gap-6 sm:grid-cols-3">
    <x-widget.verification-code name="code_error" label="With error" value="482" error="That code has expired. Request a new one." />
    <x-widget.verification-code name="code_readonly" label="Read-only" value="482913" readonly />
    <x-widget.verification-code name="code_disabled" label="Disabled" disabled />
</div>
