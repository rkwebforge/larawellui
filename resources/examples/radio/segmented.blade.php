{{-- variant="segmented": the options as one track with the chosen one raised in it, for two to four short choices. Still a radio group: the arrow keys move the choice, it submits with the form, and wire:model binds it as usual. --}}
<div class="flex flex-col gap-8">
    <x-widget.radio name="billing_cycle" label="Billing" variant="segmented" value="monthly" :options="['monthly' => 'Monthly', 'yearly' => 'Yearly']" />
    <x-widget.radio name="view" label="Show" variant="segmented" value="list" :options="[
        ['id' => 'list', 'name' => 'List'],
        ['id' => 'board', 'name' => 'Board'],
        ['id' => 'calendar', 'name' => 'Calendar', 'disabled' => true],
    ]" />
</div>
