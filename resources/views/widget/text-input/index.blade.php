@props([
    // What it submits as; its error and old input are found under it. Optional with wire:model, which then names it.
    'name' => null,
    // Defaults to one made from the name (or the wire:model property).
    'id' => null,
    // Any text-like type: text, email, url, tel, search… (email, url and tel get the matching autocomplete).
    'type' => 'text',
    // Shown above the field, and its name for screen readers.
    'label' => null,
    // The value to show. Old input wins after a failed submit; with wire:model and no value, the bound Livewire
    // property.
    'value' => null,
    // Shown while it's empty.
    'placeholder' => null,
    // An error message of your own; otherwise the validation error for the name, from the session or Livewire.
    'error' => null,
    // A hint under the field.
    'info' => null,
    // Which error bag to read the error from.
    'bag' => 'default',
    // Greyed out: it can't be changed.
    'disabled' => false,
    // Shown, and submitted, but it can't be edited.
    'readonly' => false,
    // Text at the start, inside the field (e.g. https://).
    'prefix' => null,
    // Text or a small control at the end, inside the field (e.g. a unit).
    'suffix' => null,
    // An icon name, shown at the start.
    'icon' => null,
    // With maxlength: a live count under the field (12 / 40).
    'counter' => false,
])

@php
    $field = \Bladewell\Support\FormField::make($name, $id, $errors ?? null, $error, $bag, 'input', attributes: $attributes);
    // Never echo a password back into the page.
    $value = $type === 'password' ? null : $field->old($value);
    // Browsers want an explicit autocomplete on fields they recognise; a caller's own value wins (merge keeps it).
    $autocomplete = match ($type) {
        'email' => 'email',
        'tel' => 'tel',
        'url' => 'url',
        default => null,
    };
    // Padding moves to whatever sits beside the text: an icon or prefix at the start, a suffix at the end.
    $startPadding = match (true) {
        $icon !== null => 'ps-3',
        $prefix !== null => 'ps-2',
        default => 'ps-5',
    };
    $endPadding = $suffix !== null ? 'pe-2' : 'pe-5';
@endphp

<x-widget.field :required="$attributes->has('required')" :id="$field->id" :label="$label" :error="$field->errors" :info="$info" :disabled="$disabled" :readonly="$readonly" :counter="$counter ? $attributes->get('maxlength') : null" :count="intdiv(strlen(mb_convert_encoding((string) $value, 'UTF-16LE', 'UTF-8')), 2)" :class="$attributes->get('class')">
    @if ($icon)
        <x-widget.icon :name="$icon" class="text-muted ms-5 size-4 shrink-0" />
    @elseif ($prefix)
        <span class="text-muted shrink-0 ps-5 select-none">{{ $prefix }}</span>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $field->id }}"
        @if ($name) name="{{ $name }}" @endif
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        @disabled($disabled)
        @readonly($readonly)
        {{ $field->controlAttributes($attributes, (bool) $info)->merge(['autocomplete' => $autocomplete])->class([
            $startPadding,
            $endPadding,
            'h-full w-full min-w-0 bg-transparent outline-none placeholder:text-muted disabled:cursor-not-allowed disabled:opacity-50 read-only:cursor-default',
            'group-data-invalid/field:placeholder:text-error group-data-invalid/field:focus:placeholder:text-muted',
        ]) }}
    >

    @if ($suffix)
        <span class="text-muted shrink-0 pe-5 select-none">{{ $suffix }}</span>
    @endif
</x-widget.field>
