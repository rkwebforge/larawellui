<?php

declare(strict_types=1);

namespace LarawellUi\Console;

use Composer\InstalledVersions;
use Illuminate\Console\Command;
use InvalidArgumentException;
use LarawellUi\FileStatus;
use LarawellUi\Installer;
use LarawellUi\InstallTarget;
use LarawellUi\PlannedFile;
use LarawellUi\Registry;
use LarawellUi\Requirements;
use LarawellUi\Widget;
use LogicException;

final class AddWidgetCommand extends Command
{
    protected $signature = 'larawell:add
        {widgets?* : Widget names, e.g. select datepicker (see larawell:list)}
        {--all : Install every widget}
        {--installed : Update every widget already in this app}
        {--force : Overwrite files you have edited too}
        {--dry-run : Show what would change without writing anything}';

    protected $description = 'Copy widgets, and everything they need, into this app';

    public function handle(Registry $registry, InstallTarget $target): int
    {
        $installer = new Installer($registry, $target);

        /** @var list<string> $names */
        $names = $this->option('all') ? array_keys($registry->all()) : array_values((array) $this->argument('widgets'));
        if ($this->option('installed')) {
            $installed = $installer->installed();
            if ($installed === [] && $names === []) {
                $this->components->error('No widgets are installed yet. Add some first, e.g. php artisan larawell:add '.array_key_first($registry->all()).'.');

                return self::INVALID;
            }
            $names = array_values(array_unique([...$names, ...$installed]));
        }
        if ($names === [] && $this->input->isInteractive()) {
            $names = $this->pick($registry);
        }
        if ($names === []) {
            $this->components->error('Name the widgets to add, or pass --all or --installed. Available: '.implode(', ', array_keys($registry->all())).'.');

            return self::INVALID;
        }

        // Before anything is written: on an older Tailwind the copy succeeds and every widget renders unstyled.
        $requirements = Requirements::check($target->basePath);
        foreach ($requirements->warnings as $warning) {
            $this->components->warn($warning);
        }
        if ($requirements->errors !== []) {
            foreach ($requirements->errors as $error) {
                $this->components->error($error);
            }

            return self::FAILURE;
        }

        $requested = $names;
        try {
            $widgets = $registry->resolve($names);
        } catch (InvalidArgumentException|LogicException $e) {
            $this->components->error($e->getMessage());

            return self::INVALID;
        }

        $planned = $installer->plan($widgets, (bool) $this->option('force'));
        $dryRun = (bool) $this->option('dry-run');

        if (!$dryRun) {
            $installer->apply($planned);
        }

        $count = static fn (FileStatus $status): int => count(array_filter($planned, static fn (PlannedFile $file): bool => $file->status === $status));
        $writes = $count(FileStatus::Create) + $count(FileStatus::Update);
        $skipped = $count(FileStatus::Conflict) + $count(FileStatus::Untracked);
        $names = implode(', ', array_map(static fn (Widget $widget): string => $widget->name, $widgets));

        // Say what actually happened: a re-run that writes nothing hasn't installed anything.
        $this->components->info(match (true) {
            $writes > 0 => ($dryRun ? 'Would install: ' : 'Installed: ').$names,
            $skipped > 0 => ($dryRun ? 'Nothing would be written for: ' : 'Nothing written for: ').$names,
            default => 'Already up to date: '.$names,
        });
        $this->broughtAlong($widgets, $requested);
        foreach ($planned as $file) {
            if ($file->status !== FileStatus::Unchanged || $this->output->isVerbose()) {
                $this->components->twoColumnDetail($this->relative($target, $file), $this->label($file->status));
            }
        }

        if (($edited = $count(FileStatus::Conflict)) > 0) {
            $this->components->warn("{$edited} file(s) you edited were left alone, so they miss this version's changes. See what changed with php artisan larawell:diff, or re-run with --force to replace them.");
        }
        // These predate larawellui.lock, so there's no telling an edit from an older version.
        if (($untracked = $count(FileStatus::Untracked)) > 0) {
            $this->components->warn("{$untracked} file(s) differ from this version and were installed before larawellui.lock kept track, so they were left alone. If you haven't edited them, re-run with --force (it covers every widget you name, so name only those you haven't edited); from then on updates apply by themselves.");
        }

        $this->notes($widgets, $target, rebuild: !$dryRun && $writes > 0);

        return self::SUCCESS;
    }

    /**
     * With no names in a terminal, a list to choose from rather than an error. Numbers or names, comma-separated.
     *
     * @return list<string>
     */
    private function pick(Registry $registry): array
    {
        $choices = array_map(static function (Widget $widget): string {
            // Up to the first colon or full stop: some descriptions run to a paragraph.
            $first = preg_split('/[:.](?:\s|$)/', $widget->description, 2)[0] ?? $widget->description;

            return $first.($widget->requires === [] ? '' : ' (needs '.implode(', ', $widget->requires).')');
        }, $registry->all());

        /** @var list<string> $picked */
        $picked = (array) $this->choice('Which widgets do you want to add? (comma-separated)', $choices, multiple: true);

        return array_values($picked);
    }

    /**
     * Why each widget nobody named is coming along: "modal, for pagination". The flat list alone doesn't
     * explain why two names install seven widgets.
     *
     * @param  list<Widget>  $widgets  resolved, dependencies first
     * @param  list<string>  $requested
     */
    private function broughtAlong(array $widgets, array $requested): void
    {
        $lines = [];
        foreach ($widgets as $widget) {
            if (in_array($widget->name, $requested, true)) {
                continue;
            }
            $for = array_map(
                static fn (Widget $other): string => $other->name,
                array_filter($widgets, static fn (Widget $other): bool => in_array($widget->name, $other->requires, true)),
            );
            $lines[] = "{$widget->name}, for ".implode(', ', $for);
        }

        if ($lines !== []) {
            $this->line('  Also brings:');
            $this->components->bulletList($lines);
        }
    }

    /**
     * Things the installer can't do for the user: packages and extensions to install, rules to use.
     *
     * @param  list<Widget>  $widgets
     */
    private function notes(array $widgets, InstallTarget $target, bool $rebuild): void
    {
        $packages = array_unique(array_merge(...array_map(static fn (Widget $widget): array => $widget->composer, $widgets)));
        $missing = array_filter($packages, static fn (string $package): bool => !InstalledVersions::isInstalled($package));
        if ($missing !== []) {
            $this->components->warn('Install the required packages: composer require '.implode(' ', $missing));
        }

        $extensions = array_unique(array_merge(...array_map(static fn (Widget $widget): array => $widget->phpExtensions, $widgets)));
        foreach (array_filter($extensions, static fn (string $extension): bool => !extension_loaded($extension)) as $extension) {
            $this->components->warn("Enable the PHP {$extension} extension.");
        }

        // Only the hints for rules these widgets actually bring: the input's Captcha has nothing to do with dates.
        $rules = array_unique(array_merge(...array_map(static fn (Widget $widget): array => $widget->rules, $widgets)));
        $hints = [];
        if (in_array('NotAfterToday', $rules, true)) {
            $minimumAge = in_array('MinimumAge', $rules, true) ? ' (or MinimumAge for birthdays)' : '';
            $hints[] = "Validate submitted dates with new \\{$target->rulesNamespace}\\NotAfterToday{$minimumAge}, not before_or_equal:today.";
        }
        if (in_array('Captcha', $rules, true)) {
            $hints[] = "For a Turnstile, reCAPTCHA or hCaptcha field, check the token with new \\{$target->rulesNamespace}\\Captcha('turnstile'); its keys go in config/services.php.";
        }
        if ($rebuild) {
            $hints[] = 'Rebuild your assets: npm run build (or keep npm run dev running).';
        }
        if ($hints !== []) {
            $this->components->bulletList($hints);
        }
    }

    private function label(FileStatus $status): string
    {
        return match ($status) {
            FileStatus::Create => '<fg=green>create</>',
            FileStatus::Update => '<fg=yellow>update</>',
            FileStatus::Unchanged => '<fg=gray>unchanged</>',
            FileStatus::Conflict => '<fg=red>edited, skipped</>',
            FileStatus::Untracked => '<fg=red>differs, skipped</>',
        };
    }

    private function relative(InstallTarget $target, PlannedFile $file): string
    {
        return str_starts_with($file->path, $target->basePath.'/') ? substr($file->path, strlen($target->basePath) + 1) : $file->path;
    }
}
