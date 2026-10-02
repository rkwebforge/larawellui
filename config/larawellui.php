<?php

declare(strict_types=1);

// Where `php artisan larawell:add` copies things to. Views always land in
// resources/views/components/widget, because the widgets reference each other as <x-widget.*>.
return [

    // The PHP helpers the widgets call (FormField, ElementIds). Must sit under a PSR-4 root in composer.json.
    'support_namespace' => 'App\\View\\Widget',

    // The date validation rules shipped with the date pickers.
    'rules_namespace' => 'App\\Rules',

    // Relative to the project root.
    'paths' => [
        'js' => 'resources/js/widget',
        'css' => 'resources/css/widget',
        'js_entry' => 'resources/js/app.js',
        'css_entry' => 'resources/css/app.css',
    ],

];
