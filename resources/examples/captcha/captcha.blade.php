{{-- $captchaUrl is your captcha image's URL from the controller (for example captcha_src() with mews/captcha). The refresh button shows another code. --}}
<x-widget.captcha label="Captcha" placeholder="Enter the text" :src="$captchaUrl" class="max-w-sm" />
