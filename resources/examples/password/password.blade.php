{{-- Signing in: the eye button shows the password, and a note appears while Caps Lock is on. Creating one: new sets autocomplete="new-password" and shows your rules as a checklist; match them to your Form Request, e.g. Password::min(12)->mixedCase()->numbers(). :toggle="false" hides the eye button. --}}
<div class="grid gap-6 sm:grid-cols-2">
    <x-widget.password name="password" label="Password" placeholder="Enter password" />
    <x-widget.password name="new_password" label="New password" new :min="12" mixed-case numbers symbols />
</div>
