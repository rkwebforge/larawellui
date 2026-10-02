<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

// Demo data for the preview only. A real app passes $user->logins()->latest()->paginate(5).
return static function (): array {
    $devices = ['Chrome on macOS', 'Safari on iPhone', 'Firefox on Windows', 'App on Android'];
    $places = ['Kuala Lumpur', 'Singapore', 'Penang', 'Johor Bahru'];
    $page = Paginator::resolveCurrentPage('logins_page');
    $total = 240;

    $rows = collect(range(($page - 1) * 5 + 1, min($total, $page * 5)))->map(fn (int $n): object => (object) [
        'when' => CarbonImmutable::parse('2026-09-26 18:00')->subHours($n * 7)->format('d M Y, H:i'),
        'device' => $devices[$n % count($devices)],
        'location' => $places[$n % count($places)],
    ]);

    return ['logins' => new LengthAwarePaginator($rows, $total, 5, $page, [
        'path' => request()->url(),
        'pageName' => 'logins_page',
    ])];
};
