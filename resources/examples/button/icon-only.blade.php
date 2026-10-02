{{-- icon with no text makes a square button. label is required: it is the button's name for screen readers, and its tooltip. --}}
<div class="flex flex-wrap items-center gap-3">
    <x-widget.button icon="plus" label="Add wallet" />
    <x-widget.button icon="search" label="Search" variant="secondary" />
    <x-widget.button icon="x" label="Close" variant="neutral" />
    <x-widget.button icon="eye" label="Show details" variant="tertiary" size="sm" />
    <x-widget.button icon="refresh-cw" label="Refresh" variant="neutral" size="lg" />
</div>
