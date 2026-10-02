{{-- A face with hands. numbers adds 12, 3, 6 and 9; seconds can be turned off for a calmer face. Screen readers get the time in words. --}}
<div class="flex flex-wrap items-end gap-10">
    <x-widget.clock.analog timezone="Europe/London" label="London" />
    <x-widget.clock.analog timezone="Asia/Tokyo" label="Tokyo" numbers />
    <x-widget.clock.analog timezone="America/New_York" label="New York" :seconds="false" size="sm" />
</div>
