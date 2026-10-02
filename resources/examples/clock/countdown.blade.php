{{-- Counts down to a date: launches, sale ends. The server's clock is the reference, so a wrong device clock doesn't matter. At zero it shows the done message, announces it, and fires clock:finished. --}}
<x-widget.clock.countdown label="Launch in" :to="now()->addDays(2)->addHours(4)" done="We're live!" />
