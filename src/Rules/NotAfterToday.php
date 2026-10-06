<?php

declare(strict_types=1);

namespace Bladewell\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Server-side twin of the date picker's default "no future dates" limit.
 * Use instead of 'before_or_equal:today', which uses the server's UTC date and can
 * reject a user's genuine local today.
 */
final class NotAfterToday implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $date = LocalToday::parse($value);

        if ($date === null) {
            $fail('The :attribute must be a valid date.');

            return;
        }

        if ($date->greaterThan(LocalToday::latest())) {
            $fail('The :attribute may not be in the future.');
        }
    }
}
