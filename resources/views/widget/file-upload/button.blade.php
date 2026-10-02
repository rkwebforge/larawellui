@props([
    'name' => null,
    'id' => null,
    'label' => null,
    'error' => null,
    'info' => null,
    'bag' => 'default',
    'disabled' => false,
    'multiple' => false,
    'accept' => null,
    'maxSize' => null,
    'buttonLabel' => 'Choose file',
    'emptyText' => 'No file chosen',
    'messages' => [],
])

@php
    $field = \LarawellUi\Support\FormField::make($name, $id, $errors ?? null, $error, $bag, 'file', attributes: $attributes);
    $id = $field->id;
    $limits = \LarawellUi\Support\UploadLimits::from($maxSize, $accept);
    $hint = $limits->hint();
    $hintId = $hint ? "{$id}-hint" : null;
    $inputName = $name === null ? null : ($multiple ? preg_replace('/\[\]$/', '', $name).'[]' : $name);
    $messages = [
        'tooBig' => ':name is larger than :size.',
        'wrongType' => ':name isn\'t a file type this accepts.',
        'count' => ':count files',
        ...$messages,
    ];
    // wire:model: Livewire's renders are kept off the name and error the script writes (see the dropzone).
    $live = str_starts_with((string) array_key_first(\LarawellUi\Support\FormField::binding($attributes)), 'wire:model');
    [$found, $bound] = $field->fromLivewire();
    $liveFiles = $live && $found ? (is_countable($bound) ? count($bound) : (int) filled($bound)) : null;
@endphp

{{-- Compact: a button and the chosen file's name beside it, for tight forms and table rows. Same checks as the dropzone. --}}
<x-widget.field
    :required="$attributes->has('required')"
    :id="$id"
    :label="$label"
    :error="$field->errors"
    :info="$info"
    :disabled="$disabled"
    bare
    data-file-upload="button"
    :data-max-bytes="$limits->maxBytes ?? false"
    :data-accept="$accept ?? false"
    :data-messages="json_encode($messages)"
    :data-livewire-files="$liveFiles === null ? false : (string) $liveFiles"
    :class="$attributes->get('class')"
>
    <div @if ($live) wire:ignore @endif class="flex min-w-0 flex-wrap items-center gap-x-3 gap-y-2">
        {{-- The input sits inside the button-look label, so the label's text names it and its focus rings the label. --}}
        <label @class([
            'bg-field text-foreground hover:bg-line has-[:focus-visible]:ring-primary relative inline-flex shrink-0 items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition-colors has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-offset-2',
            'cursor-pointer' => ! $disabled,
            'cursor-not-allowed opacity-60' => $disabled,
        ])>
            <x-widget.icon name="upload" class="size-4" />
            {{ $buttonLabel }}
            <input
                type="file"
                id="{{ $id }}"
                @if ($inputName) name="{{ $inputName }}" @endif
                @if ($multiple) multiple @endif
                @if ($accept) accept="{{ $accept }}" @endif
                @disabled($disabled)
                {{ $field->controlAttributes($attributes->merge(['aria-describedby' => $hintId]), (bool) $info)->class(['sr-only']) }}
            >
        </label>
        <span data-file-name data-empty="{{ $emptyText }}" class="text-foreground/75 min-w-0 truncate text-sm">{{ $emptyText }}</span>
        <button type="button" data-file-clear aria-label="Clear the chosen file" hidden class="text-foreground/60 hover:text-foreground hover:bg-field focus-visible:ring-primary -ms-1 grid size-8 shrink-0 place-items-center rounded-full outline-none focus-visible:ring-2">
            <x-widget.icon name="x" class="size-4" />
        </button>
    </div>
    @if ($hint)
        <p id="{{ $hintId }}" class="text-foreground/60 mt-1.5 text-xs">{{ $hint }}</p>
    @endif
    <p data-file-error @if ($live) wire:ignore @endif role="alert" class="text-error mt-1 text-xs empty:hidden"></p>
</x-widget.field>
