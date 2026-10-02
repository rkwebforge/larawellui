{{-- indeterminate slides while the amount isn't known yet; striped adds moving stripes to a bar that is. Both stop moving for people who prefer reduced motion. --}}
<div class="grid w-full gap-5 sm:grid-cols-2">
    <x-widget.progress indeterminate label="Preparing your export" show-label />
    <x-widget.progress :value="65" striped label="Processing payments" show-label />
</div>
