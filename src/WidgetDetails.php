<?php

declare(strict_types=1);

namespace LarawellUi;

/**
 * One widget as tools and agents read it: what it is, its components with their props and slots, what it needs, and
 * its usage and examples. Shared by larawell:list --json and larawell:mcp, so both describe a widget the same way.
 */
final readonly class WidgetDetails
{
    public function __construct(private Registry $registry) {}

    /**
     * @return array<string, mixed>
     */
    public function describe(Widget $widget): array
    {
        return [
            'description' => $widget->description,
            'components' => array_map(static fn (Component $component): array => [
                'tag' => $component->tag,
                'props' => array_map(static fn (Prop $prop): array => ['name' => $prop->name, 'default' => $prop->default, 'required' => $prop->required(), 'description' => $prop->description], $component->props),
                'slots' => (object) $component->slots,
            ], $this->registry->components($widget)),
            'requires' => $widget->requires,
            'composer' => $widget->composer,
            'php-extensions' => $widget->phpExtensions,
            'usage' => array_map(static fn (Snippet $snippet): array => [
                'title' => $snippet->title,
                'description' => $snippet->description,
                'language' => $snippet->language,
                'code' => $snippet->code,
            ], $this->registry->usage($widget)),
            'examples' => array_map(static fn (Example $example): array => [
                'title' => $example->title,
                'description' => $example->description,
                'variables' => $example->variables(),
                'code' => $example->code,
                // For your own JS file, when the example calls the widget's JS API; null otherwise.
                'script' => $example->script,
            ], $this->registry->examples($widget)),
        ];
    }
}
