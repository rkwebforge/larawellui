<?php

declare(strict_types=1);

// Demo data for the preview only: flashes the message a controller would, for this request.
return static function (): array {
    session()->now('status', 'We have emailed your password reset link.');

    return [];
};
