{{-- With multiple, choices stay picked while you search for more. Options you pass that aren't chosen show until you type: here, a few people to start from. --}}
<x-widget.select name="assignees" label="Assign to" placeholder="Search people" multiple display="chips" class="max-w-md"
    search-url="{{ route('customers.search') }}"
    :value="[9]"
    :options="[
        ['value' => 9, 'label' => 'Ben Carter', 'meta' => 'ben@example.com'],
        ['value' => 27, 'label' => 'Priya Sharma', 'meta' => 'priya@example.com'],
        ['value' => 11, 'label' => 'Chloé Martin', 'meta' => 'chloe@example.com'],
    ]" />
