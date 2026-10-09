{{-- title adds a heading that names the panel for screen readers. Focus moves to its first control; data-popover-close on a button closes it. align lines the panel up with the trigger's start, center or end. --}}
<x-widget.popover id="share-report" trigger="Share" title="Share this report" align="start">
    <p class="text-foreground/70">Anyone with the link can view it. It expires in 7 days.</p>
    <div class="mt-3 flex items-center gap-2">
        <span class="bg-field min-w-0 flex-1 truncate rounded-xl px-3 py-2 text-xs">https://example.com/r/q3-2026</span>
        <x-widget.button size="sm" data-popover-close>Done</x-widget.button>
    </div>
</x-widget.popover>
