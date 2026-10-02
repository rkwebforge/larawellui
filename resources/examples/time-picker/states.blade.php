{{-- The error clears the moment a new time is picked. Required stops an empty submit with "Choose a time." in the same place. --}}
<div class="flex flex-wrap gap-6">
    <x-widget.time-picker name="t_error" label="With error" error="Pick a time inside opening hours." class="max-w-48" />
    <x-widget.time-picker name="t_required" label="Required" required class="max-w-48" />
    <x-widget.time-picker name="t_disabled" label="Disabled" value="12:00" disabled class="max-w-48" />
</div>
