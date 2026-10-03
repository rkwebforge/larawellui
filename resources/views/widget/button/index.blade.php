@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'loading' => false,
    'disabled' => false,
    'iconStart' => null,
    'iconEnd' => null,
    'icon' => null,
    'label' => null,
    'submitGuard' => true,
])

@php
    // Disabled looks are skipped while loading (aria-busy), so a loading button keeps its colour.
    $variants = [
        'primary' => 'bg-primary text-on-primary border-transparent not-disabled:hover:bg-primary-hover disabled:not-aria-busy:bg-line disabled:not-aria-busy:text-muted',
        'secondary' => 'bg-primary/10 text-primary border-transparent not-disabled:hover:bg-primary-hover not-disabled:hover:text-on-primary disabled:not-aria-busy:bg-field disabled:not-aria-busy:text-muted',
        'tertiary' => 'bg-transparent text-primary border-primary/40 not-disabled:hover:border-primary-hover not-disabled:hover:bg-primary-hover not-disabled:hover:text-on-primary disabled:not-aria-busy:border-line disabled:not-aria-busy:text-muted',
        // For destructive actions: delete, remove, cancel a subscription.
        'danger' => 'bg-error border-transparent text-white not-disabled:hover:brightness-90 disabled:not-aria-busy:bg-line disabled:not-aria-busy:text-muted',
        // The quiet choice next to a primary action, e.g. Cancel beside Save.
        'neutral' => 'bg-field text-foreground border-transparent not-disabled:hover:bg-line disabled:not-aria-busy:text-muted',
        'link' => 'bg-transparent text-link border-transparent not-disabled:hover:text-link-hover disabled:not-aria-busy:text-muted',
    ];
    // Text and padding are separate so the link variant can keep the text size without the padding.
    $textSizes = ['sm' => 'text-xs', 'md' => 'text-sm', 'lg' => 'text-base'];
    $paddings = ['sm' => 'px-3 py-2', 'md' => 'px-4 py-3', 'lg' => 'px-6 py-3.5'];
    // Icon-only buttons are square and exactly as tall as a text button of the same size.
    $squarePaddings = ['sm' => 'p-2', 'md' => 'p-3.5', 'lg' => 'p-4'];
    // A typo fails loudly, naming the values that work, instead of quietly rendering something else.
    if (! array_key_exists($variant, $variants)) {
        throw new \InvalidArgumentException("Unknown variant [{$variant}] for <x-widget.button>. Use one of: ".implode(', ', array_keys($variants)).'.');
    }
    if (! array_key_exists($size, $textSizes)) {
        throw new \InvalidArgumentException("Unknown size [{$size}] for <x-widget.button>. Use one of: ".implode(', ', array_keys($textSizes)).'.');
    }

    // An icon with no visible text still needs a name for screen readers; fail in development rather than ship a silent button.
    $iconOnly = $icon !== null;
    if ($iconOnly && ($label === null || trim($label) === '')) {
        throw new \InvalidArgumentException("<x-widget.button icon=\"{$icon}\"> needs a label, e.g. label=\"Close\": it is the button's only name for screen readers.");
    }

    $classes = [
        'group/button relative inline-flex min-w-fit items-center justify-center gap-1.5 border font-medium whitespace-nowrap select-none transition-all outline-none',
        'focus-visible:ring-primary focus-visible:ring-2 focus-visible:ring-offset-2',
        // A guarded (busy) button is aria-disabled, not disabled, so it keeps focus; it ignores the pointer instead.
        'not-disabled:active:scale-95 disabled:cursor-not-allowed aria-busy:cursor-wait aria-busy:pointer-events-none',
        $variants[$variant],
        $textSizes[$size],
        match (true) {
            $variant === 'link' => 'rounded-md py-1',
            $iconOnly => 'rounded-xl '.$squarePaddings[$size],
            default => 'rounded-xl '.$paddings[$size],
        },
    ];

    // A disabled or loading link renders as a disabled <button>: <a> has no real disabled state.
    $isLink = $href && ! $disabled && ! $loading;
    $iconClass = $size === 'lg' ? 'size-5' : 'size-4';

    // The spinner takes the place of the first icon while busy, so the button doesn't change width.
    // It is always rendered and shown by aria-busy, so resources/js/widget/button can switch it on too.
    $spinnerSlot = $iconOnly || $iconStart ? 'start' : 'end';
    $whileBusy = 'group-aria-busy/button:hidden';
@endphp

<{{ $isLink ? 'a' : 'button' }}
    data-button
    @if ($isLink)
        href="{{ $href }}"
    @else
        type="{{ $type }}"
        @disabled($disabled || $loading)
        @if ($loading) aria-busy="true" @endif
        @if ($type === 'submit' && $submitGuard) data-submit-guard @endif
    @endif
    @if ($iconOnly) aria-label="{{ $label }}" title="{{ $label }}" @endif
    {{ $attributes->class($classes) }}
>
    @if ($spinnerSlot === 'start' && ! $isLink)
        <span class="hidden size-4 animate-spin rounded-full border-2 border-current border-r-transparent group-aria-busy/button:inline-block" aria-hidden="true"></span>
    @endif

    @if ($iconOnly)
        <x-widget.icon :name="$icon" :class="$iconClass.' '.$whileBusy" />
    @else
        @if ($iconStart)
            <x-widget.icon :name="$iconStart" :class="$iconClass.' '.$whileBusy" />
        @endif

        {{ $slot }}

        @if ($iconEnd)
            <x-widget.icon :name="$iconEnd" :class="$spinnerSlot === 'end' ? $iconClass.' '.$whileBusy : $iconClass" />
        @endif
    @endif

    @if ($spinnerSlot === 'end' && ! $isLink)
        <span class="hidden size-4 animate-spin rounded-full border-2 border-current border-r-transparent group-aria-busy/button:inline-block" aria-hidden="true"></span>
    @endif

    @if (! $isLink)
        <span class="sr-only hidden group-aria-busy/button:inline">Loading</span>
    @endif
</{{ $isLink ? 'a' : 'button' }}><?php /* No newline after this: PHP drops it after a closing tag, so no space trails the component in running text. */ ?>
