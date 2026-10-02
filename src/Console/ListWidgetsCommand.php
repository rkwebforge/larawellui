<?php

declare(strict_types=1);

namespace LarawellUi\Console;

use Illuminate\Console\Command;
use LarawellUi\Registry;
use LarawellUi\Widget;
use LarawellUi\WidgetDetails;

final class ListWidgetsCommand extends Command
{
    protected $signature = 'larawell:list {--json : Full registry as JSON: components and their props, requirements and usage examples}';

    protected $description = 'List the widgets that larawell:add can install';

    public function handle(Registry $registry, WidgetDetails $details): int
    {
        $widgets = $registry->all();

        if ($this->option('json')) {
            $this->line((string) json_encode(
                array_map($details->describe(...), $widgets),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            ));

            return self::SUCCESS;
        }

        $this->table(
            ['Widget', 'Requires', 'Description'],
            array_map(static fn (Widget $widget): array => [
                $widget->name,
                implode(', ', $widget->requires) ?: '-',
                $widget->description,
            ], array_values($widgets)),
        );

        return self::SUCCESS;
    }
}
