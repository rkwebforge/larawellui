@props([
    'id' => null,
    'trigger' => null,
    'label' => null,
    'icon' => 'ellipsis',
    'variant' => 'neutral',
    'size' => 'md',
    'align' => 'start',
])

@php
    // Scripts may open the menu by its id, so an explicit id must be unique; a derived one gets a suffix.
    $id = app(\LarawellUi\Support\ElementIds::class)->claim($id ?? 'dropdown', explicit: $id !== null);
    $menuId = "{$id}-menu";
    // Which edge of the trigger the menu lines up with: start (left in left-to-right pages) or end.
    $align = $align === 'end' ? 'end' : 'start';

    // The trigger slot is your own markup (an avatar and name, say); a string is a button with a chevron;
    // neither is an icon-only button, which needs a label.
    $custom = $trigger instanceof \Illuminate\View\ComponentSlot;
    $triggerAttributes = new \Illuminate\View\ComponentAttributeBag([
        'id' => $id,
        'popovertarget' => $menuId,
        'aria-haspopup' => 'menu',
        'aria-expanded' => 'false',
        'aria-controls' => $menuId,
        'data-dropdown-trigger' => '',
        // The script keeps aria-expanded in step with the menu; a Livewire render would put back the server's "false".
        'wire:ignore.self' => '',
    ]);
@endphp

{{--
    A menu button on the native popover: the browser opens it from popovertarget and closes it on Esc
    or a click outside, and it sits in the top layer, so a table's overflow or a modal can't clip it.
    resources/js/widget/dropdown adds the menu keyboard and positioning. data-no-row-click keeps a
    click in the menu from also opening a clickable table row.
--}}
<div data-dropdown data-no-row-click data-align="{{ $align }}" {{ $attributes->class(['relative inline-flex']) }}>
    @if ($custom)
        {{-- It is one button, so keep links and other buttons out of the slot. --}}
        <button
            type="button"
            @if ($label) aria-label="{{ $label }}" @endif
            {{ $trigger->attributes->class(['focus-visible:ring-primary inline-flex items-center gap-2 rounded-xl text-start outline-none focus-visible:ring-2 focus-visible:ring-offset-2'])->merge($triggerAttributes->getAttributes()) }}
        >{{ $trigger }}</button>
    @elseif (is_string($trigger) && $trigger !== '')
        <x-widget.button :variant="$variant" :size="$size" icon-end="chevron-down" :attributes="$triggerAttributes">{{ $trigger }}</x-widget.button>
    @else
        <x-widget.button :variant="$variant" :size="$size" :icon="$icon" :label="$label" :attributes="$triggerAttributes" />
    @endif

    <div
        id="{{ $menuId }}"
        popover
        role="menu"
        {{-- The script positions the open menu (inline top/left, data-side); a Livewire render would wipe that and the
             menu would jump. Its items still update. --}}
        wire:ignore.self
        aria-labelledby="{{ $id }}"
        data-dropdown-menu
        @class([
            // hidden until open: a display utility on a popover beats the browser's own rule that hides it while closed, and
            // the closed menu would sit there invisible, catching clicks meant for what's under it.
            'border-line bg-surface text-foreground fixed inset-auto m-0 hidden open:flex max-h-[min(24rem,calc(100dvh-2rem))] min-w-48 max-w-[calc(100vw-1rem)] flex-col overflow-y-auto overscroll-contain rounded-2xl border p-1.5 text-sm shadow-lg',
            // Fades and grows in from the trigger's side (data-side, set by the script when it flips above).
            'origin-top opacity-0 scale-95 transition-[opacity,scale,display,overlay] transition-discrete duration-150 open:opacity-100 open:scale-100 starting:open:opacity-0 starting:open:scale-95 data-[side=top]:origin-bottom motion-reduce:transition-none',
        ])
    >
        {{ $slot }}
    </div>
</div><?php /* No newline after this: PHP drops it after a closing tag, so no space trails the component in running text. */ ?>
