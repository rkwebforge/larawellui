{{-- danger is for destructive actions; neutral is the quiet choice next to a primary one, like Cancel beside Save. --}}
<div class="flex flex-wrap items-center gap-3">
    <x-widget.button>Primary</x-widget.button>
    <x-widget.button variant="secondary">Secondary</x-widget.button>
    <x-widget.button variant="tertiary">Tertiary</x-widget.button>
    <x-widget.button variant="danger">Delete</x-widget.button>
    <x-widget.button variant="neutral">Cancel</x-widget.button>
    <x-widget.button variant="link">Link</x-widget.button>
</div>
