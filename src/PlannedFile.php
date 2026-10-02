<?php

declare(strict_types=1);

namespace LarawellUi;

final readonly class PlannedFile
{
    public function __construct(
        public string $path,
        public string $contents,
        public FileStatus $status,
    ) {}
}
