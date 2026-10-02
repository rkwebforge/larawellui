<?php

declare(strict_types=1);

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

// Demo data for the preview only: 470 rows of nothing, following ?footer_page= and ?per_page= so the controls work.
// per_page is checked against the sizes on offer, as your controller should.
return static function (): array {
    $perPage = in_array(request()->integer('per_page'), [10, 25, 50, 100], true) ? request()->integer('per_page') : 10;

    return ['orders' => (new LengthAwarePaginator(range(1, $perPage), 470, $perPage, Paginator::resolveCurrentPage('footer_page'), [
        'path' => request()->url(),
        'pageName' => 'footer_page',
    ]))->appends(request()->only('per_page'))];
};
