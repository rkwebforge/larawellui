@props([
    // neutral, success, warning, error or info.
    'tone' => 'neutral',
    'dot' => true,
])

@php
    // Text is the tone mixed with the main text colour, so it stays readable (AA) on its own light tint.
    // Warning's yellow is too light for text at all, so its text stays the main colour and only the dot is yellow.
    $tones = [
        'neutral' => ['bg-field text-foreground/75', 'bg-muted'],
        'success' => ['bg-success/10 text-[color-mix(in_oklab,var(--color-success)_65%,var(--color-foreground))]', 'bg-success'],
        'warning' => ['bg-warning/20 text-foreground', 'bg-[color-mix(in_oklab,var(--color-warning)_80%,var(--color-foreground))]'],
        'error' => ['bg-error/10 text-[color-mix(in_oklab,var(--color-error)_75%,var(--color-foreground))]', 'bg-error'],
        'info' => ['bg-link/10 text-[color-mix(in_oklab,var(--color-link)_75%,var(--color-foreground))]', 'bg-link'],
    ];
    [$look, $dotColour] = $tones[$tone] ?? $tones['neutral'];
@endphp

{{-- A status in a cell: "Completed", "Failed". The words carry the meaning; colour only backs them up. --}}
<span {{ $attributes->class(['inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium whitespace-nowrap', $look]) }}>
    @if ($dot)
        <span aria-hidden="true" class="{{ $dotColour }} size-1.5 rounded-full"></span>
    @endif
    {{ $slot }}
</span><?php /* No newline after this: PHP drops it after a closing tag, so no space trails the component in running text. */ ?>
