<?php

declare(strict_types=1);

// Demo data for the preview only.
return static function (): array {
    $users = ['ana@acme.test', 'ben@acme.test', 'chen@acme.test'];
    $actions = [['Signed in', 'Success', 'success'], ['Changed role', 'Success', 'success'], ['Exported report', 'Success', 'success'], ['Signed in', 'Blocked', 'error'], ['Reset password', 'Pending', 'warning'], ['Viewed invoice', 'Viewed', 'neutral']];

    return ['events' => collect(range(1, 14))->map(fn (int $n): array => [
        'time' => sprintf('09:%02d', 58 - $n * 4 % 58),
        'user' => $users[$n % 3],
        'action' => $actions[$n % 6][0],
        'result' => $actions[$n % 6][1],
        'tone' => $actions[$n % 6][2],
    ])];
};
