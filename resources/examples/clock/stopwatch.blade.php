{{-- mode="stopwatch" counts up; mode="timer" counts down from duration (in seconds), announces the end and fires clock:finished. Pause keeps the time; Reset starts over. --}}
<div class="flex flex-wrap items-start gap-12">
    <x-widget.clock.stopwatch label="Lap time" />
    <x-widget.clock.stopwatch mode="timer" :duration="90" label="Plank" done="Done. Take a break." />
</div>
