<?php

declare(strict_types=1);

namespace LarawellUi;

final readonly class Prop
{
    /**
     * @param  string  $name  as written on the tag, e.g. icon-start
     * @param  string|null  $default  the PHP default as written in @props; null when required
     * @param  string|null  $description  the // comment right above it in @props, joined into one line
     */
    public function __construct(
        public string $name,
        public ?string $default,
        public ?string $description = null,
    ) {}

    public function required(): bool
    {
        return $this->default === null;
    }
}
