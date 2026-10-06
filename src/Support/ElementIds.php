<?php

declare(strict_types=1);

namespace Bladewell\Support;

use Illuminate\Container\Attributes\Scoped;
use LogicException;

/**
 * Keeps element ids unique within one response, so labels, aria-describedby and #fragments
 * always point at the right element. Scoped: a fresh set per request (and per Octane/queue cycle).
 */
#[Scoped]
final class ElementIds
{
    /** @var array<string, true> */
    private array $used = [];

    /**
     * Reserves an id for this response.
     *
     * A derived id (built from a field name) gets a -2, -3 … suffix when already taken. An explicit
     * id is one the caller chose and may reference from JS or CSS, so silently renaming it would
     * break that reference; a duplicate throws instead, which surfaces in development and tests.
     */
    public function claim(string $id, bool $explicit = false): string
    {
        if (! isset($this->used[$id])) {
            return $this->reserve($id);
        }

        if ($explicit) {
            throw new LogicException("Duplicate element id [{$id}] on this page. Give one of the widgets a different id or name.");
        }

        $suffix = 2;
        while (isset($this->used["{$id}-{$suffix}"])) {
            $suffix++;
        }

        return $this->reserve("{$id}-{$suffix}");
    }

    private function reserve(string $id): string
    {
        $this->used[$id] = true;

        return $id;
    }
}
