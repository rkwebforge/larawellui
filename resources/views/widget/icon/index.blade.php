@props([
    // One of the names in $icons below, e.g. chevron-down. Any other name throws, listing the ones there are.
    'name',
])

{{--
    LarawellUi's own icon set, drawn inline so there is no icon package to install. Every icon sits on a
    24px grid with about 3px of padding, and shares one style set on the <svg> below: 1.75px outline,
    round ends and joins, and softly rounded corners (radius 3 to 4 on boxes).

    To add one, draw it in that style and list each shape as [tag, attributes].

    Shapes are rendered through Blade's escaped output rather than as raw markup, so nothing here
    needs {!! !!}.
--}}
@php
    // A tiny dot, for the dots in calendars and the stems of "i" and "!".
    $dot = fn (float $x, float $y): array => ['path', ['d' => "M{$x} {$y}h.01"]];

    $icons = [
        'arrow-left' => [['path', ['d' => 'M19 12H5.5']], ['path', ['d' => 'M11 6.5 5.5 12l5.5 5.5']]],
        'arrow-right' => [['path', ['d' => 'M5 12h13.5']], ['path', ['d' => 'm13 6.5 5.5 5.5-5.5 5.5']]],
        'calendar' => [['rect', ['x' => '3.5', 'y' => '5', 'width' => '17', 'height' => '15.5', 'rx' => '4']], ['path', ['d' => 'M3.5 10h17']], ['path', ['d' => 'M8 3v4']], ['path', ['d' => 'M16 3v4']]],
        'calendar-days' => [['rect', ['x' => '3.5', 'y' => '5', 'width' => '17', 'height' => '15.5', 'rx' => '4']], ['path', ['d' => 'M3.5 10h17']], ['path', ['d' => 'M8 3v4']], ['path', ['d' => 'M16 3v4']], $dot(8, 14), $dot(12, 14), $dot(16, 14), $dot(8, 17), $dot(12, 17)],
        'calendar-range' => [['rect', ['x' => '3.5', 'y' => '5', 'width' => '17', 'height' => '15.5', 'rx' => '4']], ['path', ['d' => 'M3.5 10h17']], ['path', ['d' => 'M8 3v4']], ['path', ['d' => 'M16 3v4']], ['path', ['d' => 'M8 14h8']], ['path', ['d' => 'M8 17h4']]],
        'check' => [['path', ['d' => 'm5 12.5 4.5 4.5L19 7.5']]],
        'chevron-down' => [['path', ['d' => 'm7 10 5 5 5-5']]],
        'chevron-left' => [['path', ['d' => 'm14 7-5 5 5 5']]],
        'chevron-right' => [['path', ['d' => 'm10 7 5 5-5 5']]],
        'chevron-up' => [['path', ['d' => 'm7 14 5-5 5 5']]],
        'chevrons-left' => [['path', ['d' => 'm12.5 7-5 5 5 5']], ['path', ['d' => 'm17.5 7-5 5 5 5']]],
        'chevrons-right' => [['path', ['d' => 'm11.5 7 5 5-5 5']], ['path', ['d' => 'm6.5 7 5 5-5 5']]],
        'chevrons-up-down' => [['path', ['d' => 'm8 9.5 4-4 4 4']], ['path', ['d' => 'm8 14.5 4 4 4-4']]],
        'circle-alert' => [['circle', ['cx' => '12', 'cy' => '12', 'r' => '8.75']], ['path', ['d' => 'M12 7.75v5']], $dot(12, 16.25)],
        'circle-check' => [['circle', ['cx' => '12', 'cy' => '12', 'r' => '8.75']], ['path', ['d' => 'm8.5 12.25 2.5 2.5 4.75-5']]],
        'clock' => [['circle', ['cx' => '12', 'cy' => '12', 'r' => '8.75']], ['path', ['d' => 'M12 7.5V12l3 2']]],
        'copy' => [['rect', ['x' => '8.5', 'y' => '8.5', 'width' => '12', 'height' => '12', 'rx' => '3']], ['path', ['d' => 'M15.5 8.5v-2a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h2']]],
        // Dots are tiny circles rather than $dot, which would be too faint to read as a "more" button.
        'ellipsis' => [['circle', ['cx' => '5.5', 'cy' => '12', 'r' => '1']], ['circle', ['cx' => '12', 'cy' => '12', 'r' => '1']], ['circle', ['cx' => '18.5', 'cy' => '12', 'r' => '1']]],
        'eye' => [['path', ['d' => 'M2.75 12C4.8 7.9 8.1 5.75 12 5.75s7.2 2.15 9.25 6.25c-2.05 4.1-5.35 6.25-9.25 6.25S4.8 16.1 2.75 12Z']], ['circle', ['cx' => '12', 'cy' => '12', 'r' => '3']]],
        'eye-off' => [['path', ['d' => 'm4 4 16 16']], ['path', ['d' => 'M9.9 5.97A9.6 9.6 0 0 1 12 5.75c3.9 0 7.2 2.15 9.25 6.25a13.3 13.3 0 0 1-2.2 3.2']], ['path', ['d' => 'M6.6 7.6C5.07 8.7 3.8 10.18 2.75 12c2.05 4.1 5.35 6.25 9.25 6.25 1.6 0 3.08-.36 4.4-1.06']], ['path', ['d' => 'M10 10.1a3 3 0 0 0 3.9 3.9']]],
        'file' => [['path', ['d' => 'M14 3.5H8A2.5 2.5 0 0 0 5.5 6v12A2.5 2.5 0 0 0 8 20.5h8a2.5 2.5 0 0 0 2.5-2.5V8Z']], ['path', ['d' => 'M14 3.5V8h4.5']]],
        'image' => [['rect', ['x' => '3.5', 'y' => '4.5', 'width' => '17', 'height' => '15', 'rx' => '3.5']], ['circle', ['cx' => '9', 'cy' => '9.5', 'r' => '1.5']], ['path', ['d' => 'm20.5 15-4.2-4.2a1.5 1.5 0 0 0-2.1 0L6 19.5']]],
        'inbox' => [['path', ['d' => 'M3.5 13.5 6.2 6.6A2.5 2.5 0 0 1 8.5 5h7a2.5 2.5 0 0 1 2.3 1.6l2.7 6.9']], ['path', ['d' => 'M3.5 13.5V17A2.5 2.5 0 0 0 6 19.5h12a2.5 2.5 0 0 0 2.5-2.5v-3.5h-4.25l-1.25 2h-4l-1.25-2Z']]],
        'info' => [['circle', ['cx' => '12', 'cy' => '12', 'r' => '8.75']], ['path', ['d' => 'M12 11v5']], $dot(12, 7.75)],
        'lock' => [['rect', ['x' => '4.5', 'y' => '10.5', 'width' => '15', 'height' => '10', 'rx' => '3.5']], ['path', ['d' => 'M8 10.5V8a4 4 0 0 1 8 0v2.5']], ['path', ['d' => 'M12 14.5v2']]],
        'log-out' => [['path', ['d' => 'M9.5 20.5h-3a3 3 0 0 1-3-3v-11a3 3 0 0 1 3-3h3']], ['path', ['d' => 'm15.5 16.5 4.5-4.5-4.5-4.5']], ['path', ['d' => 'M20 12H9.5']]],
        'minus' => [['path', ['d' => 'M6 12h12']]],
        'moon' => [['path', ['d' => 'M20 14.5A8 8 0 1 1 9.5 4a6.5 6.5 0 0 0 10.5 10.5Z']]],
        'pause' => [['rect', ['x' => '6.5', 'y' => '5', 'width' => '3.5', 'height' => '14', 'rx' => '1.75']], ['rect', ['x' => '14', 'y' => '5', 'width' => '3.5', 'height' => '14', 'rx' => '1.75']]],
        'pencil' => [['path', ['d' => 'M15.25 5.25a2.47 2.47 0 0 1 3.5 3.5L9 18.5l-4.5 1 1-4.5Z']], ['path', ['d' => 'm13.5 7 3.5 3.5']]],
        'play' => [['path', ['d' => 'M7.5 5.9v12.2a1.4 1.4 0 0 0 2.1 1.2l10-6.1a1.4 1.4 0 0 0 0-2.4l-10-6.1a1.4 1.4 0 0 0-2.1 1.2Z']]],
        'plus' => [['path', ['d' => 'M12 6v12']], ['path', ['d' => 'M6 12h12']]],
        'refresh-cw' => [['path', ['d' => 'M4.5 12a7.5 7.5 0 0 1 13-5.1L19 8.5']], ['path', ['d' => 'M19 4v4.5h-4.5']], ['path', ['d' => 'M19.5 12a7.5 7.5 0 0 1-13 5.1L5 15.5']], ['path', ['d' => 'M5 20v-4.5h4.5']]],
        'rotate-ccw' => [['path', ['d' => 'M4.5 12a7.5 7.5 0 1 0 2.2-5.3L4.5 9']], ['path', ['d' => 'M4.5 4.5V9H9']]],
        'search' => [['circle', ['cx' => '10.5', 'cy' => '10.5', 'r' => '6.75']], ['path', ['d' => 'm15.5 15.5 4.5 4.5']]],
        'shield-check' => [['path', ['d' => 'M12 3.5 5 6.25v5.5c0 4.3 2.9 7.4 7 8.75 4.1-1.35 7-4.45 7-8.75v-5.5Z']], ['path', ['d' => 'm9 12 2.2 2.2 4-4.2']]],
        'sun' => [['circle', ['cx' => '12', 'cy' => '12', 'r' => '3.75']], ['path', ['d' => 'M12 3.25v1.5']], ['path', ['d' => 'M12 19.25v1.5']], ['path', ['d' => 'M3.25 12h1.5']], ['path', ['d' => 'M19.25 12h1.5']], ['path', ['d' => 'm5.8 5.8 1.05 1.05']], ['path', ['d' => 'm17.15 17.15 1.05 1.05']], ['path', ['d' => 'm5.8 18.2 1.05-1.05']], ['path', ['d' => 'm17.15 6.85 1.05-1.05']]],
        'trash' => [['path', ['d' => 'M4.5 6.5h15']], ['path', ['d' => 'M18 6.5V18a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 6 18V6.5']], ['path', ['d' => 'M9 6.5V5a1.5 1.5 0 0 1 1.5-1.5h3A1.5 1.5 0 0 1 15 5v1.5']], ['path', ['d' => 'M10 10.5v6']], ['path', ['d' => 'M14 10.5v6']]],
        'triangle-alert' => [['path', ['d' => 'M10.27 4.5 3.3 16.75a2.25 2.25 0 0 0 1.95 3.35h13.5a2.25 2.25 0 0 0 1.95-3.35L13.73 4.5a2 2 0 0 0-3.46 0Z']], ['path', ['d' => 'M12 9.5v4']], $dot(12, 16.75)],
        'upload' => [['path', ['d' => 'M12 15.5V4.5']], ['path', ['d' => 'm7.5 9 4.5-4.5L16.5 9']], ['path', ['d' => 'M4.5 15v2.5a2.5 2.5 0 0 0 2.5 2.5h10a2.5 2.5 0 0 0 2.5-2.5V15']]],
        'user' => [['circle', ['cx' => '12', 'cy' => '8.25', 'r' => '3.75']], ['path', ['d' => 'M4.75 20a7.25 7.25 0 0 1 14.5 0']]],
        'volume-2' => [['path', ['d' => 'M4 9.5v5a1 1 0 0 0 1 1h2.5l4.3 3.6a.75.75 0 0 0 1.2-.6V5.5a.75.75 0 0 0-1.2-.6L7.5 8.5H5a1 1 0 0 0-1 1Z']], ['path', ['d' => 'M16 9a4 4 0 0 1 0 6']], ['path', ['d' => 'M18.75 6.5a7.5 7.5 0 0 1 0 11']]],
        'wallet' => [['path', ['d' => 'M17 6v-.5A2.5 2.5 0 0 0 14.5 3H6a2.5 2.5 0 0 0-2.5 2.5']], ['rect', ['x' => '3.5', 'y' => '6', 'width' => '17', 'height' => '13.5', 'rx' => '3.5']], ['path', ['d' => 'M20.5 11h-3.25a1.75 1.75 0 0 0 0 3.5h3.25']]],
        'x' => [['path', ['d' => 'm6.5 6.5 11 11']], ['path', ['d' => 'm17.5 6.5-11 11']]],
    ];

    // A typo should fail loudly in development, not render an empty gap.
    $shapes = $icons[$name] ?? throw new \InvalidArgumentException("Unknown icon [{$name}]. Available: ".implode(', ', array_keys($icons)).'. Add it to resources/views/widget/icon/index.blade.php.');
@endphp

{{-- Decorative by default (hidden from screen readers). Given aria-label or aria-labelledby, it is a labelled image. --}}
@php($named = $attributes->has('aria-label') || $attributes->has('aria-labelledby'))
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" {{ $attributes->class(['shrink-0'])->merge($named ? ['role' => 'img'] : ['aria-hidden' => 'true']) }}>
    @foreach ($shapes as [$tag, $shape])
        <{{ $tag }} {{ new \Illuminate\View\ComponentAttributeBag($shape) }} />
    @endforeach
</svg><?php /* No newline after this: PHP drops it after a closing tag, so no space trails the component in running text. */ ?>
