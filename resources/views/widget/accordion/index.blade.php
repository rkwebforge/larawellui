@props([
    // The header text, or use the header slot for markup.
    'title' => null,
    // Starts open. A menu group is open unless set to false, so it paints the same on every page.
    'open' => null,
    // Items sharing a name open one at a time.
    'name' => null,
    // default, bordered, card, or menu (a group of links inside an accordion.menu).
    'variant' => 'default',
    // No padding or text style on the body, for content that runs edge to edge.
    'flush' => false,
])

@php
    // default: tinted panel while open. bordered: a divided list, for FAQs. card: each item its own card.
    $variants = [
        'default' => [
            'item' => 'rounded-2xl transition-colors duration-300 open:bg-field data-closing:bg-transparent motion-reduce:transition-none',
            'summary' => 'rounded-2xl px-5 py-4 hover:bg-field',
            'body' => 'px-5 pb-4',
        ],
        'bordered' => [
            'item' => 'border-line border-b first:border-t',
            'summary' => 'px-1 py-5 hover:text-primary',
            'body' => 'px-1 pb-5',
        ],
        'card' => [
            'item' => 'border-line bg-surface rounded-2xl border shadow-sm',
            'summary' => 'rounded-2xl px-5 py-4 hover:bg-field/60 group-open/accordion:rounded-b-none',
            'body' => 'px-5 pb-5',
        ],
        // A heading over a group of links in a sidebar: compact, and the links indented under a rule.
        'menu' => [
            'item' => '',
            'summary' => 'rounded-lg px-3 py-1.5 text-sm text-foreground/70 hover:bg-field hover:text-foreground',
            'body' => 'border-line ms-3 flex flex-col gap-0.5 border-s ps-2 pt-0.5 pb-1',
        ],
    ];
    // A typo fails loudly, naming the values that work, instead of quietly rendering something else.
    if (! array_key_exists($variant, $variants)) {
        throw new \InvalidArgumentException("Unknown variant [{$variant}] for <x-widget.accordion>. Use one of: ".implode(', ', array_keys($variants)).'.');
    }
    $menu = $variant === 'menu';
    $style = $variants[$variant];
    $open ??= $menu;
    $chevron = [$menu ? 'size-4' : 'size-6', '-rotate-90 transition-transform duration-300 group-open/accordion:rotate-0 group-data-closing/accordion:-rotate-90 rtl:rotate-90 rtl:group-open/accordion:rotate-0 rtl:group-data-closing/accordion:rotate-90 motion-reduce:transition-none'];
@endphp

{{--
    Native <details>: works with no JS (keyboard, screen readers, find-in-page all built in).
    The JS adds the open/close animation and takes over the `name` group ("one open at a time")
    so the item that closes animates too, instead of snapping shut.
--}}
@if ($menu)
    <li class="list-none">
@endif
{{-- wire:ignore.self: whether it's open, and the attributes the script moves (name, data-closing), are the person's once
     the page is up; a Livewire render would put back the server's and snap panels open or shut. What's inside still updates.
     So open only sets how a panel starts. Outside Livewire the attribute does nothing. --}}
<details
    data-accordion
    wire:ignore.self
    @if ($open) open @endif
    @if ($name) name="{{ $name }}" @endif
    {{ $attributes->class(['group/accordion w-full', $style['item']]) }}
>
    <summary @class([
        'focus-visible:ring-primary flex cursor-pointer list-none items-center justify-between gap-4 text-start outline-none select-none focus-visible:ring-2 [&::-webkit-details-marker]:hidden',
        // A menu group's heading has the same colour and weight as the links around it; its chevron marks it as a group.
        'text-foreground font-medium' => ! $menu,
        $style['summary'],
    ])>
        <span>{{ $header ?? $title }}</span>
        {{-- Closed, the chevron points to the end of the line (right, or left in right-to-left pages); open, down. --}}
        <x-widget.icon name="chevron-down" :class="implode(' ', $chevron)" />
    </summary>

    {{-- Padding lives on the inner div: the animated outer one must be able to reach 0 height.
         flush drops the padding and text style, for content that should run edge to edge (a table, a form). --}}
    <div data-accordion-content>
        @if ($menu)
            <ul class="{{ $style['body'] }}">
                {{ $slot }}
            </ul>
        @else
            <div @class(['text-foreground/75 text-sm '.$style['body'] => ! $flush])>
                {{ $slot }}
            </div>
        @endif
    </div>
</details>
@if ($menu)
    </li>
@endif
