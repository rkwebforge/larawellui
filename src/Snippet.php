<?php

declare(strict_types=1);

namespace Bladewell;

/**
 * Code-only usage: resources/usage/{widget}/{slug}.{blade.php|php|js}. For what can't be a live
 * example, such as layout setup, a controller call or a JS API. A leading comment is its description.
 */
final readonly class Snippet
{
    /**
     * @param  'blade'|'php'|'js'  $language
     */
    public function __construct(
        public string $widget,
        public string $slug,
        public string $title,
        public ?string $description,
        public string $language,
        public string $code,
    ) {}

    public function languageLabel(): string
    {
        return match ($this->language) {
            'blade' => 'Blade',
            'php' => 'PHP',
            'js' => 'JavaScript',
        };
    }
}
