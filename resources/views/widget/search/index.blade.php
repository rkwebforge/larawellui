@props([
    // What it submits as; its error and old input are found under it. Optional with wire:model, which then names it.
    'name' => null,
    // Defaults to one made from the name (or the wire:model property).
    'id' => null,
    // Defaults to the query string under the name, so a search form fills back in; or the bound Livewire property.
    'value' => null,
    // Shown while it's empty.
    'placeholder' => 'Search',
    // Its name for screen readers; defaults to the placeholder.
    'label' => null,
    // sm (32px) or md (48px).
    'size' => 'md',
    // An × button, shown while there's text, that empties the box. It fires input and change, so whatever listens (a
    // table's filters, wire:model) reacts as if the text had been deleted.
    'clearable' => true,
    // Where the magnifier sits: end (after the text) or start (before it).
    'iconPosition' => 'end',
    // A key that jumps to the box from anywhere on the page, e.g. "/", shown as a hint while the box is empty and
    // unfocused. One character, without modifiers; it doesn't fire while you're typing in another field.
    'shortcut' => null,
])

@php
    $field = \LarawellUi\Support\FormField::make($name, $id, null, idPrefix: 'search', attributes: $attributes);
    $id = $field->id;
    // Search forms submit with GET, so the current query string is the natural default (dot key: filter[q] works too).
    $fromQuery = $field->key !== null ? request()->query($field->key) : null;
    // Otherwise the value prop, or a bound Livewire property (see FormField::old).
    $value = is_string($fromQuery) ? $fromQuery : $field->old($value);
    $sizes = ['sm' => 'h-8 text-xs', 'md' => 'h-12 text-sm'];
    // A typo fails loudly, naming the values that work, instead of quietly rendering something else.
    if (! array_key_exists($size, $sizes)) {
        throw new \InvalidArgumentException("Unknown size [{$size}] for <x-widget.search>. Use one of: ".implode(', ', array_keys($sizes)).'.');
    }
    if (! in_array($iconPosition, ['end', 'start'], true)) {
        throw new \InvalidArgumentException("Unknown icon-position [{$iconPosition}] for <x-widget.search>. Use one of: end, start.");
    }
    $start = $iconPosition === 'start';
    $shortcut = is_string($shortcut) && mb_strlen($shortcut) === 1 && trim($shortcut) !== '' ? $shortcut : null;
@endphp

<div {{ $attributes->only('class')->class([
    'bg-field text-foreground hover:border-primary focus-within:border-primary relative flex w-full items-center overflow-hidden rounded-[20px] border border-transparent transition-colors',
    $sizes[$size],
    'pe-3' => $start,
]) }}>
    @if ($start)
        <x-widget.icon name="search" class="text-muted ms-4 size-4 shrink-0" />
    @endif
    <input
        type="search"
        id="{{ $id }}"
        @if ($name) name="{{ $name }}" @endif
        value="{{ $value }}"
        {{-- A space when there's no placeholder: the clear button hides on :placeholder-shown, which needs one. --}}
        placeholder="{{ $placeholder !== '' ? $placeholder : ' ' }}"
        aria-label="{{ $label ?? $placeholder }}"
        @if ($shortcut) aria-keyshortcuts="{{ $shortcut }}" data-search-shortcut="{{ $shortcut }}" @endif
        {{ $attributes->except('class')->class([
            'peer h-full w-full min-w-0 bg-transparent outline-none placeholder:text-muted [&::-webkit-search-cancel-button]:appearance-none',
            $start ? 'ps-3' : 'ps-5',
        ]) }}
    >
    @if ($clearable)
        {{-- Hidden by CSS while the box is empty (its placeholder showing), so it needs no script to stay right, even
             when something else empties the box. The browser's own clear button is hidden above: it differs in every
             browser and Firefox has none. --}}
        <button type="button" data-search-clear aria-label="Clear search" aria-controls="{{ $id }}" @class([
            'text-muted hover:text-foreground focus-visible:ring-primary grid shrink-0 place-items-center rounded-full outline-none focus-visible:ring-2 peer-placeholder-shown:hidden',
            'me-1 size-6' => $size === 'sm',
            'me-2 size-7' => $size === 'md',
        ])>
            <x-widget.icon name="x" @class(['size-3.5' => $size === 'sm', 'size-4' => $size === 'md']) />
        </button>
    @endif
    @if ($shortcut)
        {{-- The key, until the box has focus or text; screen readers get it from aria-keyshortcuts instead. --}}
        <kbd aria-hidden="true" @class([
            'border-line-strong text-muted font-code grid shrink-0 place-items-center rounded-md border text-xs peer-focus:hidden peer-[:not(:placeholder-shown)]:hidden',
            'me-2 size-5' => $size === 'sm',
            'me-3 size-6' => $size === 'md',
        ])>{{ $shortcut }}</kbd>
    @endif
    @unless ($start)
        <x-widget.icon name="search" class="text-muted me-5 size-4 shrink-0" />
    @endunless
</div>
