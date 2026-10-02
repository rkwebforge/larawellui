{{-- With href the button renders as a link. Loading and disabled both block clicks; while loading, the spinner takes the icon's place. --}}
<div class="flex flex-wrap items-center gap-3">
    <x-widget.button size="sm">Small</x-widget.button>
    <x-widget.button size="lg">Large</x-widget.button>
    <x-widget.button icon-start="plus">Add wallet</x-widget.button>
    <x-widget.button variant="secondary" icon-start="check" loading>Saving</x-widget.button>
    <x-widget.button variant="secondary" disabled>Disabled</x-widget.button>
    <x-widget.button variant="tertiary" href="#" icon-end="arrow-right">Continue</x-widget.button>
</div>
