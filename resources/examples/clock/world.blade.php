{{-- Several cities at once, each with how far ahead or behind the visitor it is, "Tomorrow" when the date has rolled over, and day or night. --}}
<x-widget.clock.world class="w-full" :zones="[
    'London' => 'Europe/London',
    'New York' => 'America/New_York',
    'Mumbai' => 'Asia/Kolkata',
    'Tokyo' => 'Asia/Tokyo',
]" />
