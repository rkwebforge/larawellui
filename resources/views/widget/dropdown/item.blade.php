@props([
    'href' => null,
    'action' => null,
    'method' => 'post',
    'icon' => null,
    'danger' => false,
    'disabled' => false,
    'confirm' => null,
    'confirmMessage' => null,
    'confirmLabel' => null,
    'confirmCancel' => null,
])

@php
    // A link (href), a form that submits (action + method, e.g. a delete), or a plain button for your own script.
    $kind = match (true) {
        $disabled => 'button',
        $action !== null => 'form',
        $href !== null => 'link',
        default => 'button',
    };
    $method = strtoupper($method);
    // Forms only speak GET and POST; anything else rides along as Laravel's _method field.
    $formMethod = $method === 'GET' ? 'GET' : 'POST';

    $classes = [
        'flex w-full shrink-0 cursor-pointer items-center gap-2.5 rounded-xl px-3 py-2 text-start whitespace-nowrap outline-none select-none transition-colors',
        'aria-disabled:cursor-not-allowed aria-disabled:opacity-40',
        // The same text-on-tint mix as the table's error badge, so a danger item stays readable (AA).
        'text-[color-mix(in_oklab,var(--color-error)_80%,var(--color-foreground))] not-aria-disabled:hover:bg-error/10 focus-visible:bg-error/10' => $danger,
        'not-aria-disabled:hover:bg-field focus-visible:bg-field' => ! $danger,
    ];
    // Roving focus: the script moves focus between items with the arrow keys, so none sits in the Tab order.
    $itemAttributes = [
        'role' => 'menuitem',
        'tabindex' => '-1',
        'aria-disabled' => $disabled ? 'true' : null,
        'data-danger' => $danger ? '' : null,
        'data-confirm' => $confirm,
        'data-confirm-message' => $confirmMessage,
        'data-confirm-label' => $confirmLabel,
        'data-confirm-cancel' => $confirmCancel,
    ];
@endphp

@if ($kind === 'form')
    <form method="{{ $formMethod }}" action="{{ $action }}" class="contents">
        @if ($formMethod === 'POST')
            @csrf
        @endif
        @if (! in_array($method, ['GET', 'POST'], true))
            @method($method)
        @endif
        <button type="submit" {{ $attributes->class($classes)->merge($itemAttributes) }}>
@elseif ($kind === 'link')
    <a href="{{ $href }}" {{ $attributes->class($classes)->merge($itemAttributes) }}>
@else
    <button type="button" {{ $attributes->class($classes)->merge($itemAttributes) }}>
@endif
        @if ($icon)
            <x-widget.icon :name="$icon" @class(['size-4', 'opacity-60' => ! $danger]) />
        @endif
        <span class="min-w-0 flex-1 truncate">{{ $slot }}</span>
@if ($kind === 'link')
    </a>
@else
        </button>
    @if ($kind === 'form')
        </form>
    @endif
@endif
