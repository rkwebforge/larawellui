<?php

declare(strict_types=1);

namespace Bladewell\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Server-side twin of the date picker's `birthday` limit: the person must have reached
 * `$years` on their own local today.
 */
final class MinimumAge implements ValidationRule
{
    public function __construct(private readonly int $years = 18) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $birthDate = LocalToday::parse($value);

        if ($birthDate === null) {
            $fail('The :attribute must be a valid date.');

            return;
        }

        // Overflow matches the browser: someone born on 29 Feb comes of age on 1 Mar in non-leap years.
        $latestAllowed = LocalToday::latest()->subYearsWithOverflow($this->years);

        if ($birthDate->greaterThan($latestAllowed)) {
            $fail("You must be at least {$this->years} years old.");
        }
    }
}
