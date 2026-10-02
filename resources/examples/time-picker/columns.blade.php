{{-- variant="columns": hour, minute and, on a 12-hour clock, AM/PM columns, for any exact minute. The arrow keys turn each column, Left and Right move between them, and hours or minutes that would leave min and max are greyed out. --}}
<x-widget.time-picker name="alarm" label="Alarm" variant="columns" value="07:45" :hour12="true" class="max-w-48" />
