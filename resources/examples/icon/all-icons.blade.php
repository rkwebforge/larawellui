{{-- Every icon in the set, by the name you pass. To add one, draw it in resources/views/widget/icon/index.blade.php. --}}
<ul class="grid grid-cols-[repeat(auto-fill,minmax(7.5rem,1fr))] gap-2">
    @foreach (['arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'bell', 'bookmark', 'calendar', 'calendar-days', 'calendar-range', 'check', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'chevrons-left', 'chevrons-right', 'chevrons-up-down', 'circle-alert', 'circle-check', 'circle-help', 'circle-x', 'clock', 'copy', 'credit-card', 'download', 'ellipsis', 'external-link', 'eye', 'eye-off', 'file', 'filter', 'globe', 'heart', 'home', 'image', 'inbox', 'info', 'link', 'lock', 'log-out', 'mail', 'map-pin', 'menu', 'minus', 'moon', 'pause', 'pencil', 'phone', 'play', 'plus', 'refresh-cw', 'rotate-ccw', 'search', 'send', 'settings', 'share', 'shield-check', 'star', 'sun', 'tag', 'trash', 'triangle-alert', 'upload', 'user', 'users', 'volume-2', 'wallet', 'x'] as $name)
        <li class="border-line text-foreground flex flex-col items-center gap-2 rounded-md border px-2 py-4">
            <x-widget.icon :name="$name" class="size-6" />
            <span class="text-muted font-mono text-xs">{{ $name }}</span>
        </li>
    @endforeach
</ul>
