{{-- Mark columns sortable with a key; clicking a header reloads with ?sort=amount&direction=desc (in place, with JS) and back to page 1. The table only draws the order: your controller must check sort against its own list of columns before it reaches orderBy(), as Usage shows. --}}
<x-widget.table caption="Payments" :rows="$payments" pagination="numbers" :columns="[
    ['label' => 'Reference', 'key' => 'reference', 'sortable' => true],
    'Customer',
    ['label' => 'Date', 'key' => 'date', 'sortable' => true],
    ['label' => 'Amount', 'key' => 'amount', 'sortable' => true, 'align' => 'end'],
]">
    @foreach ($payments as $payment)
        <x-widget.table.row>
            <td>{{ $payment['reference'] }}</td>
            <td>{{ $payment['customer'] }}</td>
            <td>{{ $payment['date'] }}</td>
            <td>{{ $payment['amount'] }}</td>
        </x-widget.table.row>
    @endforeach
</x-widget.table>
