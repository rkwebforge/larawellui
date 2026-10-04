<?php

declare(strict_types=1);

namespace LarawellUi\Rules;

use Carbon\CarbonImmutable;

/**
 * "Today" for date rules when users sit in many timezones and the app runs on UTC.
 *
 * The server's today can be a day behind a user's local today. Comparing against the
 * first timezone on Earth to reach a new day never rejects a genuine local today, and
 * still rejects anything that is in the future for everyone.
 */
final class LocalToday
{
    // UTC+14: the earliest timezone, so its date is the latest "today" anywhere.
    private const string EARLIEST_TIMEZONE = 'Pacific/Kiritimati';

    public static function latest(): CarbonImmutable
    {
        return CarbonImmutable::now(self::EARLIEST_TIMEZONE)->startOfDay();
    }

    /** Parses a strict Y-m-d date, as submitted by the date picker; anything else is null. */
    public static function parse(mixed $value): ?CarbonImmutable
    {
        if (! is_string($value) || preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $parts) !== 1) {
            return null;
        }

        if (! checkdate((int) $parts[2], (int) $parts[3], (int) $parts[1])) {
            return null;
        }

        return CarbonImmutable::createFromFormat('!Y-m-d', $value, self::EARLIEST_TIMEZONE);
    }
}
