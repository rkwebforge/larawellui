<?php

declare(strict_types=1);

namespace LarawellUi\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use LarawellUi\FileStatus;
use LarawellUi\Installer;
use LarawellUi\InstallTarget;
use LarawellUi\LineDiff;
use LarawellUi\PlannedFile;
use LarawellUi\Registry;
use Symfony\Component\Console\Formatter\OutputFormatter;

final class DiffCommand extends Command
{
    protected $signature = 'larawell:diff
        {file? : One installed file, e.g. resources/views/components/widget/select/index.blade.php or just select/index.blade.php}';

    protected $description = 'Show how installed widget files differ from this version of the package';

    public function handle(Registry $registry, InstallTarget $target, Filesystem $files): int
    {
        $installer = new Installer($registry, $target);
        $installed = $installer->installed();
        if ($installed === []) {
            $this->components->info('No widgets are installed yet, so there is nothing to compare.');

            return self::SUCCESS;
        }

        $planned = array_values(array_filter(
            $installer->plan($registry->resolve($installed)),
            static fn (PlannedFile $file): bool => !$installer->isEntry($file->path),
        ));

        /** @var string|null $file */
        $file = $this->argument('file');
        if ($file !== null) {
            $wanted = ltrim(str_replace('\\', '/', $file), '/');
            $planned = array_values(array_filter($planned, static fn (PlannedFile $p): bool => $p->path === "{$target->basePath}/{$wanted}" || str_ends_with($p->path, "/{$wanted}")));
            if ($planned === []) {
                $this->components->error("[{$file}] is not a file of any installed widget.");

                return self::FAILURE;
            }
        } else {
            // Without a file, only what a re-run would skip: the rest already matches or updates by itself.
            $planned = array_values(array_filter($planned, static fn (PlannedFile $p): bool => $p->status === FileStatus::Conflict || $p->status === FileStatus::Untracked));
            if ($planned === []) {
                $this->components->info('Every installed file matches this version, or will update by itself on php artisan larawell:add --installed.');

                return self::SUCCESS;
            }
        }

        foreach ($planned as $one) {
            $this->show($one, $target, $files);
        }

        if ($file === null) {
            $this->components->bulletList([
                'Keep yours: do nothing. Re-runs leave these files alone.',
                'Take the package version of one file: delete it, then run php artisan larawell:add --installed.',
            ]);
        }

        return self::SUCCESS;
    }

    private function show(PlannedFile $file, InstallTarget $target, Filesystem $files): void
    {
        $relative = substr($file->path, strlen($target->basePath) + 1);
        $current = $files->exists($file->path) ? $files->get($file->path) : '';

        $this->newLine();
        $this->line("<options=bold>{$relative}</>  ".match ($file->status) {
            FileStatus::Create => '<fg=green>not in your app yet</>',
            FileStatus::Unchanged => '<fg=gray>matches the package</>',
            FileStatus::Update => '<fg=yellow>not edited, updates on the next larawell:add</>',
            FileStatus::Conflict => '<fg=red>edited by you</>',
            FileStatus::Untracked => '<fg=red>differs, from before larawellui.lock</>',
        });

        $diff = LineDiff::unified($current, $file->contents);
        if ($diff === []) {
            return;
        }
        $this->line('<fg=red>--- yours</>');
        $this->line('<fg=green>+++ package</>');
        foreach ($diff as $line) {
            // Blade and JS are full of <…>, which the console would otherwise read as style tags.
            $text = OutputFormatter::escape($line);
            $this->line(match ($line[0]) {
                '@' => "<fg=cyan>{$text}</>",
                '-' => "<fg=red>{$text}</>",
                '+' => "<fg=green>{$text}</>",
                default => $text,
            });
        }
    }
}
