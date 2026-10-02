{{-- The default pagination. Tapping the current page opens a sheet listing every page, which suits phones. --}}
<x-widget.table caption="Orders" :columns="['Order', 'Customer', ['label' => 'Total', 'align' => 'end']]" :rows="$orders">
    @foreach ($orders as $order)
        <x-widget.table.row>
            <td>{{ $order->number }}</td>
            <td>{{ $order->customer }}</td>
            <td>{{ $order->total }}</td>
        </x-widget.table.row>
    @endforeach
</x-widget.table>
