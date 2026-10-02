{{-- timezone is required, so the time the server paints is the time the browser ticks on. For a user's own time, store their timezone and pass it, e.g. :timezone="$user->timezone". hour12, seconds and date add the rest. --}}
<div class="flex flex-wrap items-end gap-10">
    <x-widget.clock timezone="Asia/Kolkata" label="Mumbai" />
    <x-widget.clock timezone="America/New_York" label="New York" hour12 seconds date />
    <x-widget.clock timezone="Europe/London" label="London office" size="sm" />
</div>
