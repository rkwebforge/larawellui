{{-- A native range input underneath: the arrow keys move it a step, Page Up and Down move it further, Home and End jump to the ends. suffix (or prefix) goes on the value shown under the label and on what a screen reader hears. --}}
<x-widget.slider name="volume" label="Volume" :value="60" suffix="%" class="max-w-sm" />
