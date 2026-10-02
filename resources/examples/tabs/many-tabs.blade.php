{{-- More tabs than fit scroll sideways rather than wrapping, and the open one is scrolled into view as it changes. --}}
<x-widget.tabs id="months" label="Month" value="october" class="max-w-md" :tabs="[
    'january' => 'January', 'february' => 'February', 'march' => 'March', 'april' => 'April',
    'may' => 'May', 'june' => 'June', 'july' => 'July', 'august' => 'August',
    'september' => 'September', 'october' => 'October', 'november' => 'November', 'december' => 'December',
]">
    @foreach (['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'] as $month)
        <x-slot :name="$month">Reports for {{ ucfirst($month) }}.</x-slot>
    @endforeach
</x-widget.tabs>
