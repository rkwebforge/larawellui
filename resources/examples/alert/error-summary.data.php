<?php

declare(strict_types=1);

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

// Demo data for the preview only: the errors a failed validation would leave. In your app, Laravel shares them.
return static function (): array {
    view()->share('errors', (new ViewErrorBag)->put('default', new MessageBag([
        'email' => ['Enter an email address in the right format, like name@example.com.'],
        'password' => ['The password must be at least 12 characters.', 'The password must contain a number.'],
        'terms' => ['Accept the terms to continue.'],
    ])));

    return [];
};
