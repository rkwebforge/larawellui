<?php

declare(strict_types=1);

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

// Demo data for the preview only: 23 made-up orders, five a page, following ?more_page= so loading more works.
return static function (): array {
    $page = Paginator::resolveCurrentPage('more_page');
    $orders = collect(range(1, 23))->map(fn (int $n): array => [
        'number' => 'ORD-'.(1100 - $n),
        'total' => '$'.number_format(19 + ($n * 37) % 480, 2),
    ]);

    return ['orders' => new LengthAwarePaginator($orders->forPage($page, 5)->values(), $orders->count(), 5, $page, [
        'path' => request()->url(),
        'pageName' => 'more_page',
    ])];
};
