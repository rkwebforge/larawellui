{{-- For bookings: start from today, no upper limit. --}}
<x-widget.date-range-picker name="stay" label="Stay" min="today" :max="false" info="Check-in to check-out." class="max-w-sm" />
