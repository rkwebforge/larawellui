{{-- An image captcha in a Livewire component ($captchaUrl from the component, for example captcha_src() with mews/captcha): bind the answer with wire:model; no name is needed, and its error is read under the property. The image (and the audio) stay put through every render, so the code being answered never changes under you; the refresh button still loads a new one. Validate it as usual in the component: 'captcha' => ['required', 'captcha']. The Turnstile, reCAPTCHA and hCaptcha tokens are written by the provider's own script and aren't bound by wire:model: use those in a regular form. --}}
<form wire:submit="send" class="space-y-5">
    <x-widget.captcha label="Type the characters" :src="$captchaUrl" wire:model="captcha" />

    <button type="submit">Send</button>
</form>
