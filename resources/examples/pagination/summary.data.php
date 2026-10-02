<?php

declare(strict_types=1);

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

// Demo data for the preview only: 47 pages of nothing, following ?summary_page= so the links work.
return static fn (): array => ['orders' => new LengthAwarePaginator(range(1, 10), 470, 10, Paginator::resolveCurrentPage('summary_page'), [
    'path' => request()->url(),
    'pageName' => 'summary_page',
])];
