<?php

declare(strict_types=1);

namespace LarawellUi;

/**
 * One Blade component inside a widget, e.g. x-widget.select, with the props it declares.
 */
final readonly class Component
{
    /**
     * @param  list<Prop>  $props
     * @param  array<string, string>  $slots  named slots it renders, with what each is for (from the manifest)
     */
    public function __construct(
        public string $tag,
        public string $file,
        public array $props,
        public array $slots = [],
    ) {}
}
