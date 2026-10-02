{{-- Parts of one whole in a single bar with a legend, e.g. storage or a budget. Colours follow the theme in order unless a segment names one; what's left over shows as free. --}}
<x-widget.progress.stacked
    class="w-full"
    label="Storage"
    summary="37.5 GB of 50 GB used"
    :max="50"
    :segments="[
        ['label' => 'Photos', 'value' => 18.4, 'text' => '18.4 GB'],
        ['label' => 'Videos', 'value' => 12.1, 'text' => '12.1 GB'],
        ['label' => 'Documents', 'value' => 5, 'text' => '5 GB'],
        ['label' => 'Other', 'value' => 2, 'text' => '2 GB', 'color' => 'muted'],
    ]"
/>
