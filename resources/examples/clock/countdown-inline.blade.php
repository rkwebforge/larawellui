{{-- variant="inline" sits in running text. Short ones suit one-time codes and sessions; this one ends in 15 seconds. --}}
<div class="flex flex-col gap-3 text-sm">
    <p>Sale ends in <x-widget.clock.countdown variant="inline" :to="now()->addHours(5)->addMinutes(12)" label="Sale ends in" /></p>
    <p>Your code expires in <x-widget.clock.countdown variant="inline" :to="now()->addSeconds(15)" label="Code expires in" done="Code expired. Request a new one." /></p>
</div>
