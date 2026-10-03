{{-- Each way of getting in touch shows its own field: an email address for Email, a number for Phone. A hidden one doesn't submit, and its required can't stop the form. Email is chosen to start with, so :shown says so from the server, with no flash before the script runs. --}}
<form class="grid max-w-sm gap-6">
    <x-widget.radio name="contact" label="How should we contact you?" value="email" inline :options="['email' => 'Email', 'phone' => 'Phone']" />
    <x-widget.show-if field="contact" value="email" :shown="old('contact', 'email') === 'email'">
        <x-widget.text-input name="email" type="email" label="Email address" required />
    </x-widget.show-if>
    <x-widget.show-if field="contact" value="phone">
        <x-widget.phone name="phone" label="Phone number" required />
    </x-widget.show-if>
</form>
