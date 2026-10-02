{{-- The clock follows the locale: 9:30 AM in en-US, 09:30 in de. hour12 sets it either way. Whatever it shows, it submits 09:30. --}}
<div class="flex flex-wrap gap-6">
    <x-widget.time-picker name="t_us" label="en-US" locale="en-US" value="09:30" class="max-w-48" />
    <x-widget.time-picker name="t_de" label="de" locale="de" value="09:30" class="max-w-48" />
    <x-widget.time-picker name="t_24" label="hour12 false" :hour12="false" value="21:15" class="max-w-48" />
</div>
