{{-- A list of values shows it for any of them; here An event or Other asks for the details. --}}
<form class="grid max-w-sm gap-6">
    <x-widget.select name="heard_from" label="How did you hear about us?" placeholder="Choose one" :options="['search' => 'Search engine', 'friend' => 'A friend', 'event' => 'An event', 'other' => 'Other']" />
    <x-widget.show-if field="heard_from" :value="['event', 'other']">
        <x-widget.text-input name="heard_from_details" label="Tell us more" required />
    </x-widget.show-if>
</form>
