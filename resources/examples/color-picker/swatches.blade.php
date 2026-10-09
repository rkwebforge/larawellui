{{-- swatches offers colours to pick in one click, as a radio group: the arrow keys move between them, and a screen reader hears each one's name. Give them names (name => hex) or a plain list of hex values. custom="false" leaves out the browser's own picker, so only the box and the swatches choose. --}}
<x-widget.color-picker name="label_color" label="Label colour" value="#16a34a" :custom="false" :swatches="[
    'Red' => '#dc2626',
    'Amber' => '#d97706',
    'Green' => '#16a34a',
    'Teal' => '#0d9488',
    'Blue' => '#2563eb',
    'Violet' => '#7c3aed',
    'Slate' => '#475569',
]" class="max-w-xs" />
