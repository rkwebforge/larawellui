<?php

declare(strict_types=1);

namespace LarawellUi\Support;

use DateTimeInterface;
use IntlDateFormatter;
use IntlDatePatternGenerator;

/**
 * Times of day for <x-widget.time-picker>: "HH:MM" on a 24-hour clock, the one form it submits, and how a locale
 * writes them. A time of day has no date or timezone, so 09:30 is 09:30 for everyone. Needs PHP's intl extension.
 */
final class TimeOfDay
{
    /**
     * "HH:MM" from "9:30", "09:30:15", "9:30 PM" or a date object; null for anything else.
     */
    public static function normalize(mixed $time): ?string
    {
        if ($time instanceof DateTimeInterface) {
            return $time->format('H:i');
        }
        if (! is_string($time) || preg_match('/^\s*(\d{1,2}):(\d{2})(?::\d{2})?\s*([AaPp][Mm])?\s*$/', $time, $parts) !== 1) {
            return null;
        }
        [$hour, $minute] = [(int) $parts[1], (int) $parts[2]];
        if (isset($parts[3])) {
            if ($hour < 1 || $hour > 12) {
                return null;
            }
            $hour = $hour % 12 + (strtolower($parts[3]) === 'pm' ? 12 : 0);
        }

        return $hour <= 23 && $minute <= 59 ? sprintf('%02d:%02d', $hour, $minute) : null;
    }

    /** Minutes since midnight: 09:30 → 570. */
    public static function minutes(string $time): int
    {
        [$hour, $minute] = array_map('intval', explode(':', $time));

        return $hour * 60 + $minute;
    }

    public static function fromMinutes(int $minutes): string
    {
        $minutes = (($minutes % 1440) + 1440) % 1440;

        return sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);
    }

    /**
     * Every time from min to max, step minutes apart, counted from min: 09:00, 09:15 … 17:00. Within one day.
     *
     * @return list<string>
     */
    public static function range(string $min = '00:00', string $max = '23:59', int $step = 15): array
    {
        $step = max(1, $step);
        $times = [];
        for ($minute = self::minutes($min), $last = self::minutes($max); $minute <= $last; $minute += $step) {
            $times[] = self::fromMinutes($minute);
        }

        return $times;
    }

    /** Whether the locale writes times on a 12-hour clock (en-US, ar, hi) rather than a 24-hour one (en-GB, de, ja). */
    public static function usesHour12(string $locale): bool
    {
        $pattern = (new IntlDateFormatter(self::icu($locale), IntlDateFormatter::NONE, IntlDateFormatter::SHORT))->getPattern();

        return preg_match('/[hK]/', (string) preg_replace("/'[^']*'/", '', $pattern)) === 1;
    }

    /**
     * How the locale writes a time on the clock asked for, as a CLDR pattern: "h:mm a", "HH:mm", "aK:mm".
     */
    public static function pattern(string $locale, bool $hour12): string
    {
        $generated = IntlDatePatternGenerator::create(self::icu($locale))?->getBestPattern($hour12 ? 'hmm' : 'HHmm');

        return is_string($generated) && $generated !== '' ? $generated : ($hour12 ? 'h:mm a' : 'HH:mm');
    }

    /**
     * The locale's words for before and after noon: ['AM', 'PM'], ['vorm.', 'nachm.'], ['午前', '午後'].
     *
     * @return array{0: string, 1: string}
     */
    public static function periods(string $locale): array
    {
        $formatter = new IntlDateFormatter(self::icu($locale), IntlDateFormatter::NONE, IntlDateFormatter::NONE, 'UTC', IntlDateFormatter::GREGORIAN, 'a');

        return [(string) ($formatter->format(9 * 3600) ?: 'AM'), (string) ($formatter->format(15 * 3600) ?: 'PM')];
    }

    /**
     * The time written out with a pattern and period words from pattern() and periods(): "9:30 AM", "09:30". Filled in
     * here rather than by ICU, and the same way by resources/js/widget/time-picker, so the server's first paint and the
     * browser always agree: their ICU data can differ (PHP's is often older).
     *
     * @param  array{0: string, 1: string}  $periods
     */
    public static function format(string $time, string $pattern, array $periods): string
    {
        [$hour, $minute] = array_map('intval', explode(':', $time));

        return (string) preg_replace_callback(
            "/'((?:[^']|'')*)'|h{1,2}|H{1,2}|K{1,2}|k{1,2}|m{1,2}|a+/",
            static fn (array $token): string => match ($token[0][0]) {
                // Quoted text is literal; '' is a quote mark, inside quotes or on its own.
                "'" => $token[1] === '' ? "'" : str_replace("''", "'", $token[1]),
                'h' => self::pad($hour % 12 ?: 12, strlen($token[0])),
                'H' => self::pad($hour, strlen($token[0])),
                'K' => self::pad($hour % 12, strlen($token[0])),
                'k' => self::pad($hour ?: 24, strlen($token[0])),
                'm' => self::pad($minute, strlen($token[0])),
                default => $periods[$hour < 12 ? 0 : 1],
            },
            $pattern,
        );
    }

    private static function pad(int $number, int $width): string
    {
        return str_pad((string) $number, $width, '0', STR_PAD_LEFT);
    }

    private static function icu(string $locale): string
    {
        return str_replace('-', '_', $locale);
    }
}
