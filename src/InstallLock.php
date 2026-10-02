<?php

declare(strict_types=1);

namespace LarawellUi;

use Illuminate\Filesystem\Filesystem;
use JsonException;

/**
 * larawellui.lock in the app root: a hash of each file as larawell:add last wrote it. That is what tells
 * "you edited this" apart from "the package has a newer version": a file still matching its hash is
 * untouched, so a re-run can update it; one that doesn't is yours, and is left alone.
 *
 * Commit it, like composer.lock, so a teammate's re-run knows the same.
 */
final class InstallLock
{
    public const string FILE = 'larawellui.lock';

    /** @var array<string, string> path relative to the app root => sha256 */
    private array $hashes;

    private bool $dirty = false;

    public function __construct(
        private readonly string $basePath,
        private readonly Filesystem $files = new Filesystem,
    ) {
        $this->hashes = $this->read();
    }

    /** Whether $path is recorded at all: installed since the lock existed. */
    public function tracks(string $path): bool
    {
        return isset($this->hashes[$this->relative($path)]);
    }

    /** Whether $contents is exactly what was last installed at $path. */
    public function matches(string $path, string $contents): bool
    {
        return ($this->hashes[$this->relative($path)] ?? null) === self::hash($contents);
    }

    public function record(string $path, string $contents): void
    {
        $key = $this->relative($path);
        $hash = self::hash($contents);
        if (($this->hashes[$key] ?? null) !== $hash) {
            $this->hashes[$key] = $hash;
            $this->dirty = true;
        }
    }

    public function save(): void
    {
        if (!$this->dirty) {
            return;
        }
        ksort($this->hashes);
        $this->files->put($this->basePath.'/'.self::FILE, json_encode([
            '_readme' => 'Written by php artisan larawell:add. Lets a re-run update files you have not edited. Commit it.',
            'files' => $this->hashes,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)."\n");
        $this->dirty = false;
    }

    /**
     * Line endings don't count: git on Windows may check a file out with CRLF, and that isn't an edit.
     */
    private static function hash(string $contents): string
    {
        return hash('sha256', str_replace("\r\n", "\n", $contents));
    }

    private function relative(string $path): string
    {
        return str_starts_with($path, $this->basePath.'/') ? substr($path, strlen($this->basePath) + 1) : $path;
    }

    /**
     * @return array<string, string>
     */
    private function read(): array
    {
        $path = $this->basePath.'/'.self::FILE;
        if (!$this->files->exists($path)) {
            return [];
        }

        try {
            $data = json_decode($this->files->get($path), true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            // A mangled lock (a bad merge) only loses the history: files then count as untracked, never overwritten.
            return [];
        }
        $files = is_array($data) && is_array($data['files'] ?? null) ? $data['files'] : [];

        return array_filter($files, static fn (mixed $hash, mixed $key): bool => is_string($key) && is_string($hash), ARRAY_FILTER_USE_BOTH);
    }
}
