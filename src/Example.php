<?php

declare(strict_types=1);

namespace Bladewell;

use UnexpectedValueException;

/**
 * One usage example: resources/examples/{widget}/{slug}.blade.php. A leading Blade comment is its
 * description; the rest is the code shown, copied, and rendered as the live preview.
 *
 * An example that needs data a real app would get from its controller (a paginator, say) keeps it in
 * {slug}.data.php, which returns the view's variables. That file only feeds the preview and is never
 * shown, so the code stays exactly what you'd write in your own view.
 *
 * An example that calls a widget's JS API keeps that call in {slug}.js, shown beside the Blade and loaded
 * by the site for the preview. It goes in your own JS file: no onclick="" and no inline <script>, which a
 * Content Security Policy without 'unsafe-inline' blocks.
 */
final readonly class Example
{
    public function __construct(
        public string $widget,
        public string $slug,
        public string $title,
        public ?string $description,
        public string $code,
        public ?string $dataPath = null,
        public ?string $script = null,
    ) {}

    /** The name to render it by, under the view namespace the host registers for resources/examples. */
    public function view(string $namespace): string
    {
        return "{$namespace}::{$this->widget}.{$this->slug}";
    }

    /**
     * The preview's view variables. Built on each call, so demo data can follow the request (current page).
     *
     * @return array<string, mixed>
     */
    public function data(): array
    {
        if ($this->dataPath === null) {
            return [];
        }

        $data = (static fn (string $path): mixed => require $path)($this->dataPath);
        $data = is_callable($data) ? $data() : $data;

        if (!is_array($data)) {
            throw new UnexpectedValueException("{$this->dataPath} must return an array of view variables, or a closure that does.");
        }

        return $data;
    }

    /**
     * The variables the example expects, for readers of its code (e.g. an agent): ['transactions'].
     *
     * @return list<string>
     */
    public function variables(): array
    {
        return array_keys($this->data());
    }
}
