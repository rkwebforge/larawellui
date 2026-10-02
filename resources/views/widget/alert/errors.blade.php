@props([
    'title' => null,
    'bag' => 'default',
])

@php
    $bagged = ($errors ?? null) instanceof \Illuminate\Support\ViewErrorBag ? $errors->getBag($bag) : null;
    // One line per field (its first message), in the order the rules ran; each field still shows all of its own.
    $problems = $bagged === null ? [] : array_map(static fn (array $messages): string => (string) $messages[0], $bagged->messages());
    $count = count($problems);
    // Plain English like every component; pass title="…" for another language or wording.
    $title ??= $count === 1 ? 'There is a problem' : "There are {$count} problems";
    // Focus only after a failed submit (errors flashed to the session), not whenever it's rendered, so a
    // page that shows errors some other way doesn't jump to it on load.
    $focusOnLoad = session()->has('errors');
@endphp

{{--
    Goes at the top of a form. Each message links to its field by the id the field derives from its
    name, so it works with the input widgets as they are; the script moves focus into the field on click.
--}}
@if ($count > 0)
    <div
        data-alert
        data-alert-errors
        role="alert"
        tabindex="-1"
        @if ($focusOnLoad) data-focus-on-load @endif
        {{ $attributes->class(['border-error/30 bg-error/5 focus-visible:ring-error flex gap-3 rounded-2xl border p-4 text-sm outline-none focus-visible:ring-2']) }}
    >
        <x-widget.icon name="circle-alert" class="text-error mt-px size-5" />
        <div class="min-w-0 flex-1">
            <p class="text-foreground font-semibold">{{ $title }}</p>
            <ul class="text-foreground/80 mt-1 list-disc space-y-1 ps-5 leading-6">
                @foreach ($problems as $key => $message)
                    <li>
                        <a href="#{{ \LarawellUi\Support\FormField::idFor($key) }}" data-alert-field="{{ $key }}" class="hover:text-error underline underline-offset-2">{{ $message }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
