{{-- The usual place for a tooltip: buttons that are only an icon, which have no visible text. It shows after a short rest of the pointer, at once on keyboard focus, and hides on Esc. A title saying the same thing is dropped, so the browser's own tooltip doesn't show as well. Works the same around <x-widget.button icon="…">. --}}
<div class="flex gap-2">
    @foreach (['pencil' => 'Edit', 'copy' => 'Copy link', 'trash' => 'Delete'] as $icon => $label)
        <x-widget.tooltip :text="$label">
            <button type="button" aria-label="{{ $label }}" class="bg-field hover:bg-line focus-visible:ring-primary grid size-11 place-items-center rounded-xl outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-surface">
                <x-widget.icon :name="$icon" class="size-4" />
            </button>
        </x-widget.tooltip>
    @endforeach
</div>
