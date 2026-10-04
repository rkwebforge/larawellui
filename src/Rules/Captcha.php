<?php

declare(strict_types=1);

namespace LarawellUi\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

/**
 * Checks a Turnstile, reCAPTCHA or hCaptcha token with the provider, for <x-widget.captcha provider="…">.
 * Fails closed: a missing secret, an unreachable provider or an unexpected answer all count as a failed check.
 *
 *   'cf-turnstile-response' => ['required', new Captcha('turnstile')],
 *
 * Keys live in config/services.php (services.turnstile.key / .secret, and so on), never in code.
 */
final class Captcha implements ValidationRule
{
    /**
     * What each provider needs on the page and on the server.
     *
     * @var array<string, array{script: string, class: string, field: string, verify: string}>
     */
    public const array PROVIDERS = [
        'turnstile' => [
            'script' => 'https://challenges.cloudflare.com/turnstile/v0/api.js',
            'class' => 'cf-turnstile',
            'field' => 'cf-turnstile-response',
            'verify' => 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
        ],
        'recaptcha' => [
            'script' => 'https://www.google.com/recaptcha/api.js',
            'class' => 'g-recaptcha',
            'field' => 'g-recaptcha-response',
            'verify' => 'https://www.google.com/recaptcha/api/siteverify',
        ],
        'hcaptcha' => [
            'script' => 'https://js.hcaptcha.com/1/api.js',
            'class' => 'h-captcha',
            'field' => 'h-captcha-response',
            'verify' => 'https://api.hcaptcha.com/siteverify',
        ],
    ];

    public function __construct(private readonly string $provider)
    {
        if (! isset(self::PROVIDERS[$provider])) {
            throw new InvalidArgumentException("Unknown captcha provider [{$provider}]. Use turnstile, recaptcha or hcaptcha.");
        }
    }

    /** The field the provider's widget submits its token in, e.g. cf-turnstile-response. */
    public static function field(string $provider): string
    {
        return self::PROVIDERS[$provider]['field'] ?? throw new InvalidArgumentException("Unknown captcha provider [{$provider}].");
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config("services.{$this->provider}.secret");

        if (! is_string($value) || $value === '' || ! is_string($secret) || $secret === '') {
            $fail('Please confirm you are not a robot.');

            return;
        }

        try {
            $response = Http::asForm()->timeout(5)->post(self::PROVIDERS[$this->provider]['verify'], [
                'secret' => $secret,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);
        } catch (ConnectionException) {
            $fail('We could not check that you are not a robot. Please try again.');

            return;
        }

        if ($response->json('success') !== true) {
            $fail('Please confirm you are not a robot.');
        }
    }
}
