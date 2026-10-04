{{-- Need an icon the set doesn't have? With Blade Icons (blade-ui-kit/blade-icons) and one of its sets installed, give its name anywhere a widget takes an icon: the button, dropdown items, inputs, tabs and the rest. It's drawn with the same classes and screen-reader handling as the built-in icons. Built-in names still win, and an unknown name still fails loudly. --}}
{{-- composer require blade-ui-kit/blade-icons mallardduck/blade-lucide-icons (or another Blade Icons set: heroicon-o-…, tabler-…) --}}
<x-widget.button icon-start="lucide-rocket">Launch</x-widget.button>

<x-widget.dropdown label="More">
    <x-widget.dropdown.item icon="lucide-zap">Boost</x-widget.dropdown.item>
</x-widget.dropdown>

<x-widget.icon name="lucide-party-popper" class="size-5" />
