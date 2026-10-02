{{-- flush drops the body's padding and text style, so content like this list runs edge to edge. --}}
<x-widget.accordion variant="card" title="Fees by network" open flush>
    <dl class="divide-line border-line divide-y border-t text-sm">
        @foreach (['TRC20' => '1.00 USDT', 'ERC20' => '4.50 USDT', 'BEP20' => '0.80 USDT'] as $network => $fee)
            <div class="flex justify-between px-5 py-3">
                <dt class="text-foreground/75">{{ $network }}</dt>
                <dd class="font-medium">{{ $fee }}</dd>
            </div>
        @endforeach
    </dl>
</x-widget.accordion>
