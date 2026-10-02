<?php

declare(strict_types=1);

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

// Demo data for the preview only. A real app passes Order::query()->latest()->paginate(5).
return static function (): array {
    $customers = ['Aisha Rahman', 'Daniel Tan', 'Priya Nair', 'Wei Ling', 'Omar Haddad', 'Sofia Reyes'];
    $all = collect(range(1, 32))->map(fn (int $n): object => (object) [
        'number' => '#'.(5000 + $n),
        'customer' => $customers[$n % count($customers)],
        'total' => number_format(($n * 53) % 900 + 19.99, 2),
    ]);
    $page = Paginator::resolveCurrentPage('orders_page');

    return ['orders' => new LengthAwarePaginator($all->forPage($page, 5)->values(), $all->count(), 5, $page, [
        'path' => request()->url(),
        'pageName' => 'orders_page',
    ])];
};
