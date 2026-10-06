@props([
    // Names the navigation for screen readers ("Components", "Settings").
    'label',
    // Keep where it was scrolled from page to page, under this key ("docs"), or the label's with just `remember`.
    'remember' => null,
])

@php
    $key = match (true) {
        $remember === true => 'bladewell:accordion-menu:'.\Illuminate\Support\Str::slug($label),
        is_string($remember) && $remember !== '' => 'bladewell:accordion-menu:'.$remember,
        default => null,
    };
@endphp

{{--
    A sidebar menu that scrolls on its own: links (accordion.menu-item) and groups of them (an accordion with
    variant="menu"). Give it a height, e.g. class="max-h-96", or one that fills the window.

    It paints already scrolled to the current page, with no script: the current item is the container's
    scroll-initial-target, centred by its snap alignment, so there's no flash of the top of the list first.
    Groups are open from the server for the same reason. Where the browser doesn't support scroll-initial-target
    yet, resources/js/widget/accordion brings the current item into view after the page loads.

    overflow-anchor: none, so a group opening or closing leaves the heading you clicked where it is. With anchoring on, the
    browser keeps an item inside the animating group steady instead, and the list slides under the pointer.
--}}
<nav data-accordion-menu @if ($key) data-accordion-menu-remember="{{ $key }}" @endif aria-label="{{ $label }}" {{ $attributes->class(['relative overflow-y-auto overscroll-contain pe-3 [overflow-anchor:none] [scrollbar-width:thin]']) }}>
    {{-- wire:ignore.self: the script keeps room at the end of the list as a group closes (an inline padding), which a
         Livewire render would drop, sliding the list. --}}
    <ul wire:ignore.self class="flex flex-col gap-0.5 text-sm">
        {{ $slot }}
    </ul>
</nav>
@if ($key)
    {{-- remember: put the menu back where it was left (resources/js/widget/accordion saves that on leaving the page),
         unless that leaves the current item out of view. Inline and synchronous on purpose, so it runs the moment the
         menu is parsed and the first paint already shows it there; the deferred bundle would run after that paint and
         jump. It carries the app's CSP nonce, if there is one (Vite::useCspNonce()). Under a CSP that blocks it, the
         menu still opens with the current item centred, only without remembering. --}}
    <script @if ($nonce = \Illuminate\Support\Facades\Vite::cspNonce()) nonce="{{ $nonce }}" @endif>
        (() => {
            const menu = document.currentScript.previousElementSibling;
            let saved = 0;
            try {
                saved = Number(sessionStorage.getItem(@js($key))) || 0;
            } catch {
                return;
            }
            if (saved === 0) {
                return;
            }
            menu.scrollTop = saved;
            const current = menu.querySelector('[aria-current="page"]');
            if (current && (current.offsetTop < menu.scrollTop || current.offsetTop + current.offsetHeight > menu.scrollTop + menu.clientHeight)) {
                menu.scrollTop = current.offsetTop - (menu.clientHeight - current.offsetHeight) / 2;
            }
        })();
    </script>
@endif
