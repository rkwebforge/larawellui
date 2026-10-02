{{-- Rows with href act as links (keyboard included) without nesting a link in every cell. Amounts sit at the end of their column so the digits line up; statuses are badges. $transactions is a paginator from your controller; see Usage. --}}
<x-widget.table caption="Recent transactions" :columns="['Reference', ['label' => 'Amount', 'align' => 'end'], 'Status']" :rows="$transactions" pagination="numbers">
    @foreach ($transactions as $transaction)
        <x-widget.table.row :href="route('transactions.show', $transaction)">
            <td>{{ $transaction->reference }}</td>
            <td>{{ $transaction->amount }}</td>
            <td><x-widget.table.badge :tone="$transaction->status === 'Failed' ? 'error' : 'success'">{{ $transaction->status }}</x-widget.table.badge></td>
        </x-widget.table.row>
    @endforeach
</x-widget.table>
