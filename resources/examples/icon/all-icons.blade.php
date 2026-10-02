{{-- Every icon in the set, by the name you pass. To add one, draw it in resources/views/widget/icon/index.blade.php. --}}
<ul class="grid grid-cols-[repeat(auto-fill,minmax(7.5rem,1fr))] gap-2">
    @foreach (['arrow-left', 'arrow-right', 'calendar', 'calendar-days', 'calendar-range', 'check', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'chevrons-left', 'chevrons-right', 'chevrons-up-down', 'circle-alert', 'circle-check', 'clock', 'copy', 'ellipsis', 'eye', 'eye-off', 'file', 'image', 'inbox', 'info', 'lock', 'log-out', 'minus', 'moon', 'pause', 'pencil', 'play', 'plus', 'refresh-cw', 'rotate-ccw', 'search', 'shield-check', 'sun', 'trash', 'triangle-alert', 'upload', 'user', 'volume-2', 'wallet', 'x'] as $name)
        <li class="border-line text-foreground flex flex-col items-center gap-2 rounded-md border px-2 py-4">
            <x-widget.icon :name="$name" class="size-6" />
            <span class="text-muted font-mono text-xs">{{ $name }}</span>
        </li>
    @endforeach
</ul>
