// An image captcha is checked by whatever generated it, e.g. mews/captcha's rule.
'captcha' => ['required', 'captcha'],

// A provider token is checked with the provider. Keys go in config/services.php, read from .env:
// 'turnstile' => ['key' => env('TURNSTILE_SITE_KEY'), 'secret' => env('TURNSTILE_SECRET_KEY')],
use App\Rules\Captcha;

'cf-turnstile-response' => ['required', new Captcha('turnstile')],
// reCAPTCHA: 'g-recaptcha-response', hCaptcha: 'h-captcha-response' (or Captcha::field('hcaptcha')).
