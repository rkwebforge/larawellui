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
    // How many characters the code has; extra ones are dropped.
    'length' => 6,
    // Letters and digits instead of digits only.
    'alphanumeric' => false,
])

@php
    $length = max(1, (int) $length);
    $field = \Bladewell\Support\FormField::make($name, $id, $errors ?? null, $error, $bag, 'code', attributes: $attributes);
    $value = substr((string) preg_replace($alphanumeric ? '/[^a-zA-Z0-9]/' : '/\D/', '', (string) $field->old($value)), 0, $length);
    $placeholder ??= str_repeat($alphanumeric ? 'X' : '0', $length);
@endphp

{{-- Length is enforced in JS rather than maxlength: maxlength truncates a pasted "12-34-56" before the dashes are stripped. --}}
<x-widget.field :required="$attributes->has('required')" :id="$field->id" :label="$label" :error="$field->errors" :info="$info" :disabled="$disabled" :readonly="$readonly" :class="$attributes->get('class')">
    <input
        type="text"
        id="{{ $field->id }}"
        @if ($name) name="{{ $name }}" @endif
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        data-code-input="{{ $alphanumeric ? 'alphanumeric' : 'numeric' }}"
        data-length="{{ $length }}"
        @disabled($disabled)
        @readonly($readonly)
        {{-- Defaults, so a caller's own autocomplete="off" or inputmode wins instead of producing a duplicate the browser ignores. --}}
        {{ $field->controlAttributes($attributes, (bool) $info)->merge(['inputmode' => $alphanumeric ? 'text' : 'numeric', 'autocomplete' => 'one-time-code', 'autocapitalize' => 'off', 'spellcheck' => 'false'])->class([
            'h-full w-full min-w-0 bg-transparent px-5 text-center text-2xl tracking-[0.2em] outline-none placeholder:text-muted disabled:cursor-not-allowed disabled:opacity-50 read-only:cursor-default',
            'group-data-invalid/field:placeholder:text-error group-data-invalid/field:focus:placeholder:text-muted',
        ]) }}
    >
</x-widget.field>
