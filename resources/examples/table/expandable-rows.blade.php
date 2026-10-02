{{-- A details slot makes the row expandable. A chevron on the right shows which rows open, and turns when they do. --}}
<x-widget.table caption="Payouts" :columns="['Reference', ['label' => 'Amount', 'align' => 'end'], 'Status']" :rows="$payouts">
    @foreach ($payouts as $payout)
        <x-widget.table.row>
            <td>{{ $payout->reference }}</td>
            <td>{{ $payout->amount }}</td>
            <td>{{ $payout->status }}</td>
            <x-slot:details>
                <p class="text-foreground/75 text-sm">Sent to the account ending {{ $payout->account }} on {{ $payout->sent_on }}.</p>
            </x-slot:details>
        </x-widget.table.row>
    @endforeach
</x-widget.table>
