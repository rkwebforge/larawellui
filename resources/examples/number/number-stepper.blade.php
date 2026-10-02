{{-- stepper adds - and + buttons (ArrowUp and ArrowDown work too), moving by step within min and max. A typed value outside the range is pulled back in when the field is left. --}}
<div class="flex flex-wrap gap-6">
    <x-widget.number name="guests" label="Guests" :decimals="0" value="2" :min="1" :max="10" stepper class="max-w-44" />
    <x-widget.number name="nights" label="Nights" :decimals="0" value="3" :min="1" :max="30" stepper class="max-w-44" />
</div>
