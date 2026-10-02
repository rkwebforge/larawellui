<?php

declare(strict_types=1);

// Demo data for the preview only.
return static fn (): array => ['orders' => collect([
    ['number' => '#3021', 'customer' => 'Priya Nair', 'placed' => '12 Sep 2026', 'status' => 'Delivered', 'tone' => 'success', 'total' => '$84.20'],
    ['number' => '#3022', 'customer' => 'Tom Becker', 'placed' => '13 Sep 2026', 'status' => 'Shipped', 'tone' => 'info', 'total' => '$129.00'],
    ['number' => '#3023', 'customer' => 'Lina Haddad', 'placed' => '14 Sep 2026', 'status' => 'Refunded', 'tone' => 'error', 'total' => '$42.50'],
])];
