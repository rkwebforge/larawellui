<?php

declare(strict_types=1);

namespace Bladewell;

use Bladewell\Console\AddWidgetCommand;
use Bladewell\Console\DiffCommand;
use Bladewell\Console\ListWidgetsCommand;
use Bladewell\Console\McpCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Console-only. The installed widgets are plain files in the app and don't need this package at runtime.
 */
final class BladewellServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bladewell.php', 'bladewell');

        $this->app->singleton(Registry::class, static fn (): Registry => new Registry(dirname(__DIR__)));
        $this->app->bind(InstallTarget::class, fn (): InstallTarget => InstallTarget::fromConfig(
            $this->app->basePath(),
            $this->app->make('config')->get('bladewell'),
        ));
    }

    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([AddWidgetCommand::class, DiffCommand::class, ListWidgetsCommand::class, McpCommand::class]);
        $this->publishes([__DIR__.'/../config/bladewell.php' => $this->app->configPath('bladewell.php')], 'bladewell-config');
    }
}
