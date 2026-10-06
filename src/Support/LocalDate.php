<?php

declare(strict_types=1);

namespace Bladewell\Support;

use IntlCalendar;
use IntlDateFormatter;
use IntlDatePatternGenerator;

/**
 * How a locale writes and lays out dates, for the date pickers. The server renders the first paint with
 * this and the browser (Intl.DateTimeFormat) takes over, both asking ICU for the same "year, short month,
 * day" pattern, so a date reads "Sep 26, 2026" in en-US and "26 Sept 2026" in en-GB either way.
 * Falls back to plain ISO dates when PHP's intl extension is missing.
 */
final class LocalDate
{
    /** "en_GB" or "en-GB" → "en-GB", the form Intl in the browser expects. */
    public static function locale(?string $locale = null): string
    {
        return str_replace('_', '-', $locale ?? app()->getLocale());
    }

    /**
     * A Y-m-d date the way the locale writes it: "Sep 26, 2026", "26 Sept 2026", "2026年9月26日".
     */
    public static function format(string $iso, ?string $locale = null): string
    {
        $locale = self::locale($locale);
        if (! class_exists(IntlDatePatternGenerator::class)) {
            return $iso;
        }

        $pattern = (new IntlDatePatternGenerator($locale))->getBestPattern('yMMMd');
        $formatter = new IntlDateFormatter($locale, IntlDateFormatter::NONE, IntlDateFormatter::NONE, 'UTC', IntlDateFormatter::GREGORIAN, $pattern ?: 'y-MM-dd');
        $formatted = $formatter->format(new \DateTimeImmutable($iso, new \DateTimeZone('UTC')));

        return is_string($formatted) ? $formatted : $iso;
    }

    /**
     * First day of the week, as JavaScript counts days (0 = Sunday … 6 = Saturday): Monday in most of
     * the world, Sunday in the US, Saturday in parts of the Middle East.
     */
    public static function firstDayOfWeek(?string $locale = null): int
    {
        if (! class_exists(IntlCalendar::class)) {
            return 1; // ISO 8601
        }

        $calendar = IntlCalendar::createInstance(null, str_replace('-', '_', self::locale($locale)));
        $first = $calendar instanceof IntlCalendar ? $calendar->getFirstDayOfWeek() : false;

        // ICU counts 1 = Sunday … 7 = Saturday.
        return is_int($first) ? ($first - 1) % 7 : 1;
    }
}
