@props([
    // The trail, from the top: each a label, or ['label' => 'Orders', 'href' => route('orders.index')], plus
    // 'icon' => 'home' for an icon before it, and 'iconOnly' => true to show the icon alone (the label still names it).
    // The last is the page you're on.
    'items',
    // The trail's name for screen readers.
    'label' => 'Breadcrumb',
    // What sits between the steps: chevron or slash.
    'separator' => 'chevron',
    // On phones, only a link back to the page above ("← Orders"), as a whole trail wouldn't fit. The full trail
    // from sm up.
    'collapse' => true,
])

@php
    // A typo fails loudly, naming the values that work, instead of quietly rendering something else.
    if (! in_array($separator, ['chevron', 'slash'], true)) {
        throw new \InvalidArgumentException("Unknown separator [{$separator}] for <x-widget.breadcrumbs>. Use one of: chevron, slash.");
    }
    $items = array_values(array_map(static fn (string|array $item): array => is_string($item) ? ['label' => $item] : $item, $items));
    if ($items === [] || in_array(null, array_map(static fn (array $item): ?string => $item['label'] ?? null, $items), true)) {
        throw new \InvalidArgumentException('<x-widget.breadcrumbs> needs items, each with a label: a string, or [\'label\' => …, \'href\' => …].');
    }
    $last = count($items) - 1;
    // The page above, for the phone's back link: the nearest earlier step with a link.
    $parent = collect(array_slice($items, 0, $last))->reverse()->first(static fn (array $item): bool => ! empty($item['href']));
    $collapsed = $collapse && $parent !== null;
    $link = 'hover:text-foreground focus-visible:ring-primary rounded-md underline-offset-4 outline-none hover:underline focus-visible:ring-2';
@endphp

<nav aria-label="{{ $label }}" {{ $attributes->class(['text-sm']) }}>
    @if ($collapsed)
        {{-- Phones: one link up. The list below is hidden there, so screen readers hear the same thing as the eye. --}}
        <a href="{{ $parent['href'] }}" @class(['text-foreground/70 inline-flex max-w-full items-center gap-1 sm:hidden', $link])>
            <x-widget.icon name="chevron-left" class="size-4 rtl:rotate-180" />
            <span class="truncate">{{ $parent['label'] }}</span>
        </a>
    @endif
    <ol @class(['text-foreground/70 flex min-w-0 flex-wrap items-center gap-x-1.5 gap-y-1', 'max-sm:hidden' => $collapsed])>
        @foreach ($items as $i => $item)
            <li class="flex min-w-0 items-center gap-1.5">
                @if ($i > 0)
                    @if ($separator === 'chevron')
                        <x-widget.icon name="chevron-right" class="text-foreground/40 size-4 rtl:rotate-180" />
                    @else
                        <span aria-hidden="true" class="text-foreground/40">/</span>
                    @endif
                @endif
                @php($current = $i === $last)
                @php($tag = empty($item['href']) ? 'span' : 'a')
                {{-- The current page is named as such (aria-current), and stays a link only if it was given one.
                     title shows a label cut short in full. --}}
                <{{ $tag }}
                    @if ($tag === 'a') href="{{ $item['href'] }}" @endif
                    @if ($current) aria-current="page" @endif
                    title="{{ $item['label'] }}"
                    @class(['inline-flex min-w-0 items-center gap-1.5', $link => $tag === 'a', 'text-foreground font-medium' => $current])
                >
                    @if (! empty($item['icon']))
                        <x-widget.icon :name="$item['icon']" class="size-4" />
                    @endif
                    {{-- iconOnly: the icon alone shows (a home icon); the label still names it for screen readers. --}}
                    <span @class(['max-w-48 truncate', 'sr-only' => ! empty($item['icon']) && ! empty($item['iconOnly'])])>{{ $item['label'] }}</span>
                </{{ $tag }}>
            </li>
        @endforeach
    </ol>
</nav>
