@props([
    'position' => 'top-right',
    'autoClose' => 3000,
    'showProgress' => true,
    'pauseOnHover' => true,
    'pauseOnFocusLoss' => true,
])

@php
    $positions = [
        'top-left' => 'top-4 left-4 flex-col',
        'top-center' => 'top-4 left-1/2 -translate-x-1/2 flex-col',
        'top-right' => 'top-4 right-4 flex-col',
        'center' => 'top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex-col',
        'bottom-left' => 'bottom-4 left-4 flex-col-reverse',
        'bottom-center' => 'bottom-4 left-1/2 -translate-x-1/2 flex-col-reverse',
        'bottom-right' => 'bottom-4 right-4 flex-col-reverse',
    ];
    // A typo fails loudly, naming the values that work, instead of quietly rendering something else.
    if (! array_key_exists($position, $positions)) {
        throw new \InvalidArgumentException("Unknown position [{$position}] for <x-widget.toast>. Use one of: ".implode(', ', array_keys($positions)).'.');
    }

    // Flash messages: ->with('success', '...'), or ->with('toast', ['type' => ..., 'message' => ..., 'title' => ...]).
    $flashTypes = ['success', 'error', 'warning', 'info'];
    $flashed = collect($flashTypes)
        ->filter(fn (string $type): bool => is_string(session($type)))
        ->map(fn (string $type): array => ['type' => $type, 'message' => session($type)])
        ->values()
        ->all();

    $custom = session('toast');
    if (is_array($custom) && is_string($custom['message'] ?? null)) {
        $flashed[] = [
            'type' => in_array($custom['type'] ?? null, [...$flashTypes, 'comingSoon'], true) ? $custom['type'] : 'info',
            'message' => $custom['message'],
            'title' => is_string($custom['title'] ?? null) ? $custom['title'] : null,
        ];
    }
@endphp

{{-- popover="manual" puts toasts in the browser's top layer, above page content and dropdowns. --}}
<div
    popover="manual"
    role="region"
    aria-label="Notifications"
    data-toast-container
    data-position="{{ $position }}"
    data-auto-close="{{ $autoClose === false ? 'false' : (int) $autoClose }}"
    data-show-progress="{{ $showProgress ? 'true' : 'false' }}"
    data-pause-on-hover="{{ $pauseOnHover ? 'true' : 'false' }}"
    data-pause-on-focus-loss="{{ $pauseOnFocusLoss ? 'true' : 'false' }}"
    {{ $attributes->class([$positions[$position], 'pointer-events-none fixed inset-auto m-0 w-[min(24rem,calc(100vw-2rem))] gap-3 overflow-visible border-0 bg-transparent p-0 open:flex']) }}
></div>

@if ($flashed)
    {{-- A fresh id per page: a copy of this page brought back later (wire:navigate's Back and Forward) carries the same
         one, and the script shows each id once. --}}
    <script type="application/json" data-toast-flash="{{ \Illuminate\Support\Str::random(16) }}">@json($flashed)</script>
@endif
