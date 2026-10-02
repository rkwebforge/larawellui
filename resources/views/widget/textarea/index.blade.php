@props([
    // What it submits as; its error and old input are found under it. Optional with wire:model, which then names it.
    'name' => null,
    // Defaults to one made from the name (or the wire:model property).
    'id' => null,
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
    // The height to start at, in lines.
    'minRows' => 3,
    // Grows up to this many lines, then scrolls (5 by default; no limit when resizable).
    'maxRows' => null,
    // With maxlength: a live count under the field (12 / 40).
    'counter' => false,
    // Lets people drag it taller instead of sizing it to the text.
    'resizable' => false,
])

@php
    $field = \LarawellUi\Support\FormField::make($name, $id, $errors ?? null, $error, $bag, 'textarea', attributes: $attributes);
    $value = $field->old($value);
    // Up to 30: the heights are classes from the ranges at the end of base.css, not style="".
    $minRows = max(1, min(30, (int) $minRows));
    // Auto-grow stops at 5 rows unless told otherwise. A resizable textarea has no cap unless max-rows sets one:
    // the user decides its height, so the browser can't also size it to the content.
    $maxRows = match (true) {
        $maxRows !== null => max($minRows, min(30, (int) $maxRows)),
        $resizable => null,
        default => max($minRows, 5),
    };
@endphp

<x-widget.field :required="$attributes->has('required')" :id="$field->id" :label="$label" :error="$field->errors" :info="$info" :disabled="$disabled" :readonly="$readonly" :box="$resizable ? 'items-start pe-2 pb-2' : 'items-start'" :counter="$counter ? $attributes->get('maxlength') : null" :count="intdiv(strlen(mb_convert_encoding((string) $value, 'UTF-16LE', 'UTF-8')), 2)" :class="$attributes->get('class')">
    {{-- Grows with its content via CSS field-sizing (the JS only steps in for browsers without it), or, when
         resizable, keeps the height the user drags it to. 2rem = py-4. --}}
    <textarea
        id="{{ $field->id }}"
        @if ($name) name="{{ $name }}" @endif
        rows="{{ $minRows }}"
        placeholder="{{ $placeholder }}"
        @disabled($disabled)
        @readonly($readonly)
        @unless ($resizable) data-autosize @endunless
        {{ $field->controlAttributes($attributes, (bool) $info)->class([
            "min-h-[calc({$minRows}lh+2rem)]",
            "max-h-[calc({$maxRows}lh+2rem)]" => $maxRows !== null,
            'field-sizing-content resize-none' => ! $resizable,
            'resize-y' => $resizable,
            'w-full bg-transparent px-5 py-4 outline-none placeholder:text-muted disabled:cursor-not-allowed disabled:opacity-50 read-only:cursor-default',
            'group-data-invalid/field:placeholder:text-error group-data-invalid/field:focus:placeholder:text-muted',
        ]) }}
    >{{ $value }}</textarea>
</x-widget.field>
