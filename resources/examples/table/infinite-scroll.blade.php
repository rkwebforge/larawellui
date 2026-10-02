{{-- The table scrolls inside itself and loads rows at either end as you go, dropping far-off ones, so the page stays light at any size. Pair it with cursorPaginate(), which costs the same on the millionth row as the first. --}}
<x-widget.table caption="All transactions" :columns="['Reference', 'Date', ['label' => 'Amount', 'align' => 'end']]" :rows="$transactions" pagination="infinite">
    @foreach ($transactions as $transaction)
        <x-widget.table.row>
            <td>{{ $transaction->reference }}</td>
            <td>{{ $transaction->date }}</td>
            <td>{{ $transaction->amount }}</td>
        </x-widget.table.row>
    @endforeach
</x-widget.table>
