<?php

declare(strict_types=1);

namespace LarawellUi;

enum FileStatus: string
{
    case Create = 'create';
    case Update = 'update';
    case Unchanged = 'unchanged';

    /** The user edited it after it was installed (it no longer matches larawellui.lock), so it's left alone. */
    case Conflict = 'conflict';

    /**
     * It differs from upstream and there's no record of installing it (it predates larawellui.lock), so
     * whether it was edited is unknown; it's left alone too.
     */
    case Untracked = 'untracked';

    public function writes(): bool
    {
        return $this === self::Create || $this === self::Update;
    }
}
