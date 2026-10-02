{{-- variant="slots": a grid of times to choose one of, for bookings. Pass the times with :slots, marking taken ones disabled, or leave it out for every time from min to max. They're real radio buttons, so the arrow keys and required work with no script. --}}
<x-widget.time-picker name="appointment" label="Appointment" variant="slots" :slots="[
    '09:00', '09:30', ['time' => '10:00', 'disabled' => true], '10:30',
    '11:00', ['time' => '11:30', 'disabled' => true], '14:00', '14:30',
]" value="10:30" />
