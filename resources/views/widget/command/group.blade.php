@props([
    // The heading over the group's items, which also names the group for screen readers.
    'label',
])

@php
    $headingId = 'command-group-'.\Illuminate\Support\Str::random(8);
@endphp

{{-- Hidden with its items when none of them matches what's typed. --}}
<div role="group" aria-labelledby="{{ $headingId }}" data-command-group {{ $attributes->class(['py-1']) }}>
    <div id="{{ $headingId }}" class="text-muted px-3 pt-2 pb-1 text-xs font-medium">{{ $label }}</div>
    {{ $slot }}
</div>
