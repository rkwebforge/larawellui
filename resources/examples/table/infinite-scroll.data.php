<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Illuminate\Pagination\Cursor;
use Illuminate\Pagination\CursorPaginator;

// Demo data for the preview only: a virtual 1,000,000-row table, paged by cursor exactly as
// Transaction::query()->latest('id')->cursorPaginate(10, cursorName: 'feed_cursor') would page it.
return static function (): array {
    $total = 1_000_000;
    $perPage = 10;
    $cursor = Cursor::fromEncoded(request()->query('feed_cursor'));
    $id = (int) $cursor?->parameter('id');
    if ($id < 1 || $id > $total) {
        $cursor = null; // an edited or stale cursor starts over instead of failing
    }

    // What WHERE id < ? ORDER BY id DESC LIMIT 11 (next) or WHERE id > ? ORDER BY id ASC LIMIT 11 (previous)
    // returns; the extra row tells the paginator whether there is another page.
    $ids = match (true) {
        $cursor === null => range($total, $total - $perPage),
        $cursor->pointsToNextItems() => $id > 1 ? range($id - 1, max(1, $id - 1 - $perPage)) : [],
        default => $id < $total ? range($id + 1, min($total, $id + 1 + $perPage)) : [],
    };

    return ['transactions' => new CursorPaginator(
        collect($ids)->map(fn (int $n): object => (object) [
            'id' => $n,
            'reference' => 'TX-'.str_pad((string) $n, 7, '0', STR_PAD_LEFT),
            'date' => CarbonImmutable::parse('2026-09-26 12:00')->subMinutes(($total - $n) * 3)->format('d M Y, H:i'),
            'amount' => number_format(($n % 997) * 3.5, 2),
        ]),
        $perPage,
        $cursor,
        ['path' => request()->url(), 'cursorName' => 'feed_cursor', 'parameters' => ['id']],
    )];
};
