{{-- Small dots for short wizards and carousels; the current step stretches into a pill. --}}
<div class="flex flex-col items-center gap-6">
    <x-widget.stepper.dots :total="4" :current="2" label="Welcome tour" />
    <x-widget.stepper.dots :total="6" :current="5" label="Photo" />
</div>
