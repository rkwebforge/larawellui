<?php

declare(strict_types=1);

namespace LarawellUi;

use Illuminate\Support\ServiceProvider;
use LarawellUi\Console\AddWidgetCommand;
use LarawellUi\Console\DiffCommand;
use LarawellUi\Console\ListWidgetsCommand;
use LarawellUi\Console\McpCommand;

/**
 * Console-only. The installed widgets are plain files in the app and don't need this package at runtime.
 */
final class LarawellUiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/larawellui.php', 'larawellui');

        $this->app->singleton(Registry::class, static fn (): Registry => new Registry(dirname(__DIR__)));
        $this->app->bind(InstallTarget::class, fn (): InstallTarget => InstallTarget::fromConfig(
            $this->app->basePath(),
            $this->app->make('config')->get('larawellui'),
        ));
    }

    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([AddWidgetCommand::class, DiffCommand::class, ListWidgetsCommand::class, McpCommand::class]);
        $this->publishes([__DIR__.'/../config/larawellui.php' => $this->app->configPath('larawellui.php')], 'larawellui-config');
    }
}
