<?php

declare(strict_types=1);

// Demo data for the preview only. A real app passes something like Payout::query()->latest()->get().
return ['payouts' => collect(range(1, 3))->map(fn (int $n): object => (object) [
    'reference' => 'PO-'.(1040 + $n),
    'amount' => number_format($n * 812.4, 2),
    'status' => 'Paid',
    'account' => '4821',
    'sent_on' => ($n + 3).' Sep 2026',
])];
