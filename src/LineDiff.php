<?php

declare(strict_types=1);

namespace LarawellUi;

/**
 * A unified diff of two texts, line by line, for larawell:diff. Written here rather than pulled in, because the
 * package keeps to illuminate/* and the user's machine may have no diff binary (Windows).
 */
final class LineDiff
{
    /** Past this many line pairs the LCS table costs more memory than it's worth; the change is shown whole. */
    private const int MAX_CELLS = 4_000_000;

    /**
     * @return list<string> the diff lines ('@@ …', ' kept', '-removed', '+added'), empty when the texts match
     */
    public static function unified(string $from, string $to, int $context = 3): array
    {
        $a = self::lines($from);
        $b = self::lines($to);
        if ($a === $b) {
            return [];
        }

        $ops = self::ops($a, $b);

        $changes = array_keys(array_filter($ops, static fn (array $op): bool => $op[0] !== ' '));
        $groups = [];
        foreach ($changes as $index) {
            $last = array_key_last($groups);
            if ($last !== null && $index - $groups[$last][1] <= 2 * $context) {
                $groups[$last][1] = $index;
            } else {
                $groups[] = [$index, $index];
            }
        }

        $out = [];
        foreach ($groups as [$first, $lastChange]) {
            $start = max(0, $first - $context);
            $end = min(count($ops) - 1, $lastChange + $context);
            $hunk = array_slice($ops, $start, $end - $start + 1);

            $fromLength = count(array_filter($hunk, static fn (array $op): bool => $op[0] !== '+'));
            $toLength = count(array_filter($hunk, static fn (array $op): bool => $op[0] !== '-'));
            // Lines of each side before the hunk; an empty side is numbered by the line it follows.
            [$fromBefore, $toBefore] = [$ops[$start][2], $ops[$start][3]];
            $out[] = sprintf('@@ -%d,%d +%d,%d @@', $fromBefore + ($fromLength > 0 ? 1 : 0), $fromLength, $toBefore + ($toLength > 0 ? 1 : 0), $toLength);
            foreach ($hunk as [$type, $line]) {
                $out[] = $type.$line;
            }
        }

        return $out;
    }

    /**
     * Each line once, in order, as [' '|'-'|'+', line, lines of $a before it, lines of $b before it].
     *
     * @param  list<string>  $a
     * @param  list<string>  $b
     * @return list<array{string, string, int, int}>
     */
    private static function ops(array $a, array $b): array
    {
        // Shared ends are kept as they are, so the table only spans the part that changed.
        $prefix = 0;
        while ($prefix < count($a) && $prefix < count($b) && $a[$prefix] === $b[$prefix]) {
            $prefix++;
        }
        $suffix = 0;
        while ($suffix < count($a) - $prefix && $suffix < count($b) - $prefix && $a[count($a) - 1 - $suffix] === $b[count($b) - 1 - $suffix]) {
            $suffix++;
        }
        $midA = array_slice($a, $prefix, count($a) - $prefix - $suffix);
        $midB = array_slice($b, $prefix, count($b) - $prefix - $suffix);

        $middle = [];
        $n = count($midA);
        $m = count($midB);
        if ($n * $m > self::MAX_CELLS) {
            foreach ($midA as $line) {
                $middle[] = ['-', $line];
            }
            foreach ($midB as $line) {
                $middle[] = ['+', $line];
            }
        } else {
            // $lcs[$i][$j]: the longest common subsequence of $midA from $i on and $midB from $j on.
            $lcs = array_fill(0, $n + 1, array_fill(0, $m + 1, 0));
            for ($i = $n - 1; $i >= 0; $i--) {
                for ($j = $m - 1; $j >= 0; $j--) {
                    $lcs[$i][$j] = $midA[$i] === $midB[$j] ? $lcs[$i + 1][$j + 1] + 1 : max($lcs[$i + 1][$j], $lcs[$i][$j + 1]);
                }
            }
            [$i, $j] = [0, 0];
            while ($i < $n || $j < $m) {
                if ($i < $n && $j < $m && $midA[$i] === $midB[$j]) {
                    $middle[] = [' ', $midA[$i++]];
                    $j++;
                } elseif ($i < $n && ($j === $m || $lcs[$i + 1][$j] >= $lcs[$i][$j + 1])) {
                    // Removals first on a tie, so a replaced line reads old then new.
                    $middle[] = ['-', $midA[$i++]];
                } else {
                    $middle[] = ['+', $midB[$j++]];
                }
            }
        }

        $all = [
            ...array_map(static fn (string $line): array => [' ', $line], array_slice($a, 0, $prefix)),
            ...$middle,
            ...array_map(static fn (string $line): array => [' ', $line], array_slice($a, count($a) - $suffix)),
        ];

        $ops = [];
        [$fromBefore, $toBefore] = [0, 0];
        foreach ($all as [$type, $line]) {
            $ops[] = [$type, $line, $fromBefore, $toBefore];
            $fromBefore += $type !== '+' ? 1 : 0;
            $toBefore += $type !== '-' ? 1 : 0;
        }

        return $ops;
    }

    /**
     * @return list<string>
     */
    private static function lines(string $text): array
    {
        $text = str_replace("\r\n", "\n", $text);

        return $text === '' ? [] : explode("\n", rtrim($text, "\n"));
    }
}
