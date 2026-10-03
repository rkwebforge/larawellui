<?php

declare(strict_types=1);

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

// Demo data for the preview only. The sort key is checked against a fixed list, as a controller must.
return static function (): array {
    $customers = ['Ana Silva', 'Ben Carter', 'Chen Wei', 'Dara Okafor', 'Eli Novak', 'Farah Aziz'];
    $all = collect(range(1, 24))->map(fn (int $n): array => [
        'reference' => 'PAY-'.str_pad((string) (1000 + ($n * 7) % 97), 4, '0', STR_PAD_LEFT),
        'customer' => $customers[$n % count($customers)],
        'date' => now()->startOfYear()->addDays(($n * 11) % 250)->format('Y-m-d'),
        'value' => round(12 + fmod($n * 53.7, 900), 2),
    ]);
    $sort = in_array(request()->query('sort'), ['reference', 'date', 'amount'], true) ? request()->query('sort') : 'date';
    $all = $all->sortBy($sort === 'amount' ? 'value' : $sort, SORT_REGULAR, request()->query('direction') === 'desc')->values()
        ->map(fn (array $payment): array => [...$payment, 'amount' => '$'.number_format($payment['value'], 2)]);
    $page = Paginator::resolveCurrentPage('pay_page');

    return ['payments' => (new LengthAwarePaginator($all->forPage($page, 6)->values(), $all->count(), 6, $page, [
        'path' => request()->url(),
        'pageName' => 'pay_page',
    ]))->withQueryString()];
};
