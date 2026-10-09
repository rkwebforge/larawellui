@props([
    // Its name for screen readers. With the checkbox look it's also shown above the tree, as a field's label.
    'label' => null,
    // list: rows with indent guides, like a file explorer. cards: each node a card, joined to its children by lines.
    // org: top-down, each parent centred over its children, like an org chart. checkbox: rows with a tick box each;
    // ticking a parent ticks everything under it, and one with only some ticked shows a dash.
    'variant' => 'list',
    // checkbox: what the ticked values submit as (name[]). Optional with wire:model, which then names it.
    'name' => null,
    // Defaults to one made from the name (or the wire:model property).
    'id' => null,
    // checkbox: the ticked values. Old input wins after a failed submit; with wire:model and no value, the bound property.
    'value' => null,
    // checkbox: an error message of your own; otherwise the validation error for the name, from the session or Livewire.
    'error' => null,
    // checkbox: a hint under the tree.
    'info' => null,
    // checkbox: which error bag to read the error from.
    'bag' => 'default',
])

@php
    // A typo fails loudly, naming the values that work, instead of quietly rendering something else.
    if (! in_array($variant, ['list', 'cards', 'org', 'checkbox'], true)) {
        throw new \InvalidArgumentException("Unknown variant [{$variant}] for <x-widget.tree>. Use one of: list, cards, org, checkbox.");
    }
    $checkbox = $variant === 'checkbox';
    // Only the checkbox look is a form control, with a field's label, error and hint.
    $field = $checkbox ? \Bladewell\Support\FormField::make($name, $id, $errors ?? null, $error, $bag, 'tree', attributes: $attributes) : null;
    // The ticked values, as strings (backed enums as their value), for the hidden select below.
    $ticked = $checkbox
        ? collect(\Illuminate\Support\Arr::wrap($field->old($value)))->map(fn (mixed $v): string => (string) ($v instanceof \BackedEnum ? $v->value : $v))->unique()->values()
        : collect();
    // Cards and org charts grow sideways with depth, so they scroll inside themselves rather than widen the page.
    $scrolls = in_array($variant, ['cards', 'org'], true);
@endphp

@if ($checkbox)
    {{--
        What submits, and what wire:model binds, is a hidden multiple select of the ticked values: the script keeps it in
        step as boxes are ticked, and ticks the boxes from it as the page loads and after each Livewire render. Values
        under a branch that hasn't been opened yet stay in it untouched.
    --}}
    <x-widget.field :id="$field->id" :label="$label" :error="$field->errors" :info="$info" :labels-control="false" bare :class="$attributes->get('class')">
        <ul
            id="{{ $field->id }}"
            role="tree"
            data-tree
            data-variant="checkbox"
            @if ($label) aria-labelledby="{{ $field->id }}-label" @endif
            {{ $field->aria($attributes, (bool) $info) }}
            class="group/tree flex flex-col"
        >
            {{ $slot }}
        </ul>
        <select multiple hidden data-tree-value @if ($name) name="{{ $name }}[]" @endif {{ $field->bindings($attributes) }}>
            @foreach ($ticked as $tickedValue)
                <option value="{{ $tickedValue }}" selected>{{ $tickedValue }}</option>
            @endforeach
        </select>
    </x-widget.field>
@else
    <div {{ $attributes->class(['overflow-x-auto overscroll-x-contain' => $scrolls]) }}>
        <ul
            @if ($id) id="{{ $id }}" @endif
            role="tree"
            data-tree
            data-variant="{{ $variant }}"
            @if ($label) aria-label="{{ $label }}" @endif
            @class(['group/tree', 'flex flex-col' => $variant === 'list', 'w-max min-w-full p-1' => $scrolls])
        >
            {{ $slot }}
        </ul>
    </div>
@endif
