@props([
    // What it submits as; its error and old input are found under it. Optional with wire:model, which then names it.
    'name' => null,
    // Defaults to one made from the name (or the wire:model property).
    'id' => null,
    // The group's legend, read before each option.
    'label' => null,
    // A list, a value => label map, enum cases, or rows (value or id, label or name) with an optional description
    // and disabled.
    'options' => [],
    // The chosen value. Old input wins after a failed submit; with wire:model and no value, the bound property.
    'value' => null,
    // An error message of your own; otherwise the validation error for the name, from the session or Livewire.
    'error' => null,
    // A hint under the field.
    'info' => null,
    // Which error bag to read the error from.
    'bag' => 'default',
    // Greyed out: it can't be changed.
    'disabled' => false,
    // Side by side instead of stacked.
    'inline' => false,
])

@php
    $field = \LarawellUi\Support\FormField::make($name, $id, $errors ?? null, $error, $bag, 'radio', attributes: $attributes);
    // Values cast to backed enums on the model (Plan::Pro) compare and submit as their backing value.
    $text = static fn (mixed $v): string => (string) ($v instanceof \BackedEnum ? $v->value : $v);
    $selected = $field->old($value);
    $selected = $selected === null ? null : $text($selected);

    // Same option shapes as the select: a list (['Card', 'Bank'], or Plan::cases()), a key => label map, or
    // rows with id / name, plus an optional description and disabled.
    $items = collect($options)->map(function (mixed $option, int|string $key) use ($options, $text): array {
        if (is_array($option)) {
            return [
                'value' => $text($option['id'] ?? $option['value'] ?? $key),
                'label' => (string) ($option['name'] ?? $option['label'] ?? ''),
                'description' => $option['description'] ?? null,
                'disabled' => (bool) ($option['disabled'] ?? false),
            ];
        }
        if ($option instanceof \BackedEnum) {
            return ['value' => $text($option), 'label' => $option->name, 'description' => null, 'disabled' => false];
        }

        return ['value' => array_is_list($options) ? (string) $option : (string) $key, 'label' => (string) $option, 'description' => null, 'disabled' => false];
    })->values();
@endphp

{{-- A fieldset with a legend, so screen readers announce the question along with each choice. --}}
<x-widget.field :id="$field->id" :error="$field->errors" :info="$info" :disabled="$disabled" :required="$attributes->has('required')" bare :class="$attributes->get('class')">
    <fieldset id="{{ $field->id }}" @disabled($disabled)>
        @if ($label)
            <legend @class(['text-style-2 mb-[11.5px] block', 'text-muted' => $disabled, 'text-foreground' => ! $disabled])>
                {{ $label }}
                @if ($attributes->has('required'))
                    <span class="text-error" aria-hidden="true">*</span>
                @endif
            </legend>
        @endif

        <div @class(['flex gap-x-6 gap-y-3', 'flex-wrap' => $inline, 'flex-col' => ! $inline])>
            @foreach ($items as $i => $item)
                @php($optionId = "{$field->id}-{$i}")
                <label for="{{ $optionId }}" @class(['flex items-start gap-3', 'cursor-pointer' => ! ($disabled || $item['disabled']), 'cursor-not-allowed opacity-60' => $disabled || $item['disabled']])>
                    <input
                        type="radio"
                        id="{{ $optionId }}"
                        @if ($name) name="{{ $name }}" @endif
                        value="{{ $item['value'] }}"
                        @checked($selected === $item['value'])
                        @disabled($item['disabled'])
                        {{ $field->controlAttributes($attributes, (bool) $info)->class([
                            // border-muted: an unchecked radio's ring must reach 3:1 against the page to be seen at all.
                            'border-muted bg-surface mt-0.5 size-5 shrink-0 appearance-none rounded-full border transition-all outline-none',
                            // A thick border in the brand colour reads as the filled dot.
                            'checked:border-primary checked:border-[6px] focus-visible:ring-primary focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
                            'group-data-invalid/field:border-error disabled:cursor-not-allowed',
                        ]) }}
                    >
                    <span class="min-w-0">
                        <span class="text-foreground">{{ $item['label'] }}</span>
                        @if ($item['description'])
                            <span class="text-foreground/60 mt-0.5 block text-xs">{{ $item['description'] }}</span>
                        @endif
                    </span>
                </label>
            @endforeach
        </div>
    </fieldset>
</x-widget.field>
