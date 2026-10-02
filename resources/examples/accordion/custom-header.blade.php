{{-- Pass a header slot instead of a title to put anything in the summary row. --}}
<x-widget.accordion>
    <x-slot:header>
        <span class="flex items-center gap-2">
            Account limits
            <span class="bg-primary/10 text-primary rounded-full px-2 py-0.5 text-xs">Verified</span>
        </span>
    </x-slot:header>
    Daily withdrawal limit: 50,000 USDT. Monthly: 1,000,000 USDT.
</x-widget.accordion>
