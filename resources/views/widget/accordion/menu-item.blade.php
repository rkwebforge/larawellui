@props([
    // Where the link goes: another page, or a #section of this one.
    'href',
    // The page you're on: highlighted, announced as the current page, and where the menu opens scrolled to.
    // For #section links, resources/js/widget/accordion moves it as they're clicked and as the URL's #hash changes.
    'current' => false,
])

<li class="list-none">
    {{-- Styled from aria-current, not from the prop, so the highlight follows the script when it moves aria-current.
         scroll-initial-target: the menu starts scrolled to the server's current link, centred, before the first paint. --}}
    {{-- wire:ignore.self: the script moves aria-current to the #section clicked and drops scroll-initial-target after load;
         a Livewire render would put both back. The text inside still updates. --}}
    <a
        wire:ignore.self
        href="{{ $href }}"
        @if ($current) aria-current="page" @endif
        {{ $attributes->class([
            'focus-visible:ring-primary block rounded-lg px-3 py-1.5 outline-none focus-visible:ring-2',
            'text-foreground/70 hover:bg-field hover:text-foreground',
            'aria-[current=page]:bg-primary aria-[current=page]:text-on-primary aria-[current=page]:font-medium aria-[current=page]:hover:bg-primary aria-[current=page]:hover:text-on-primary',
            'snap-center [scroll-initial-target:nearest]' => $current,
        ]) }}
    >{{ $slot }}</a>
</li>
