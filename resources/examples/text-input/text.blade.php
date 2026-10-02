{{-- Old input and validation errors for the field's name are filled in from the session. --}}
<div class="grid gap-6 sm:grid-cols-2">
    <x-widget.text-input name="full_name" label="Full name" placeholder="Jane Doe" />
    <x-widget.text-input name="email" type="email" label="Email" placeholder="jane@example.com" info="We'll never share your email." />
</div>
