{{-- stack turns each row into a card of label and value lines below the sm breakpoint, instead of a table you scroll sideways. Try it on a narrow screen. --}}
<x-widget.table caption="Orders" stack :columns="['Order', 'Customer', 'Placed', 'Status', ['label' => 'Total', 'align' => 'end']]" :rows="$orders">
    @foreach ($orders as $order)
        <x-widget.table.row>
            <td class="font-medium">{{ $order['number'] }}</td>
            <td>{{ $order['customer'] }}</td>
            <td>{{ $order['placed'] }}</td>
            <td><x-widget.table.badge :tone="$order['tone']">{{ $order['status'] }}</x-widget.table.badge></td>
            <td>{{ $order['total'] }}</td>
        </x-widget.table.row>
    @endforeach
</x-widget.table>
