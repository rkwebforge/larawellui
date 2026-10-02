{{-- A submit button guards against double submits: once its form submits, it shows its loading state until the next page arrives. --}}
<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    {{-- your fields --}}
    <x-widget.button type="submit">Save changes</x-widget.button>

    {{-- Opt out where the page stays open after submitting, such as a file download. --}}
    <x-widget.button type="submit" formaction="{{ route('profile.export') }}" :submit-guard="false" variant="neutral">Export CSV</x-widget.button>
</form>
