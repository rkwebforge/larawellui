{{-- The usual place for it: the bars of a chart, each with its own reading that follows the pointer along it. A bar can't take focus, so the tooltip makes it focusable and names it with its text, so keyboard and screen reader users get each reading too. --}}
<div class="flex h-40 items-end gap-2" role="list" aria-label="Orders this week">
    {{-- Each bar's height as a class written out in full, so Tailwind sees it: a share of the busiest day. --}}
    @foreach ([
        'Mon' => ['orders' => 12, 'height' => 'h-[39%]'], 'Tue' => ['orders' => 19, 'height' => 'h-[61%]'],
        'Wed' => ['orders' => 8, 'height' => 'h-[26%]'], 'Thu' => ['orders' => 23, 'height' => 'h-[74%]'],
        'Fri' => ['orders' => 31, 'height' => 'h-full'], 'Sat' => ['orders' => 17, 'height' => 'h-[55%]'],
        'Sun' => ['orders' => 6, 'height' => 'h-[19%]'],
    ] as $day => $bar)
        <x-widget.tooltip-cursor :text="$day.': '.$bar['orders'].' orders'" role="listitem" class="h-full flex-1 items-end">
            <span class="bg-primary/80 hover:bg-primary block w-full rounded-t-md transition-colors {{ $bar['height'] }}"></span>
        </x-widget.tooltip-cursor>
    @endforeach
</div>
