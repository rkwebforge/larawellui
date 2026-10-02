{{-- provider uses Cloudflare Turnstile, Google reCAPTCHA or hCaptcha instead of an image: most people just tick a box, or see nothing. The site key comes from config/services.php; check the token on the server with the Captcha rule (see Usage). --}}
<x-widget.captcha provider="turnstile" label="Security check" />
