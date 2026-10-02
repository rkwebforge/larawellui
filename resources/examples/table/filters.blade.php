{{-- Put the fields in the filters slot: the table filters as you type (after a short pause) or pick, in place, back on page 1 and keeping the sort; the URL follows, so a reload or a shared link shows the same rows. Each option's count (its meta) says how many orders picking it would show, and updates as you filter. Shift+click a header to sort by several columns (multi-sort). Columns marked hideable get a Columns menu. The footer slot holds a totals row. while-loading="skeleton" shows placeholder rows during slower loads, and cache-for="60" makes going back to a filter seen in the last minute instant. Without JS the fields are an ordinary GET form. Your controller must check every filter and sort key against its own list, as Usage shows. --}}
<x-widget.table
    id="orders"
    caption="Orders"
    :rows="$orders"
    pagination="numbers"
    multi-sort
    sort-name="order_sort"
    direction-name="order_dir"
    while-loading="skeleton"
    cache-for="60"
    empty="No orders match these filters"
    :columns="[
        ['label' => 'Order', 'key' => 'number', 'sortable' => true],
        ['label' => 'Customer', 'hideable' => true],
        ['label' => 'Status', 'key' => 'status', 'sortable' => true, 'hideable' => true],
        ['label' => 'Payment', 'hideable' => true],
        ['label' => 'Date', 'key' => 'date', 'sortable' => true, 'hideable' => true],
        ['label' => 'Amount', 'key' => 'amount', 'sortable' => true, 'align' => 'end'],
    ]"
>
    <x-slot:filters>
        <x-widget.search name="order_q" placeholder="Search orders or customers" />
        <x-widget.select name="order_status" label="Status" inner-label clearable placeholder="Any" :options="$statuses" :value="$filters['status']" class="sm:min-w-0 sm:flex-[1_1_13rem]" />
        <x-widget.select name="order_payment" label="Payment" inner-label clearable placeholder="Any" :options="$payments" :value="$filters['payment']" class="sm:min-w-0 sm:flex-[1_1_13rem]" />
        <x-widget.select name="order_period" label="Date" inner-label clearable placeholder="Any" :options="$periods" :value="$filters['period']" class="sm:min-w-0 sm:flex-[1_1_13rem]" />
    </x-slot:filters>

    @foreach ($orders as $order)
        <x-widget.table.row>
            <td>{{ $order['number'] }}</td>
            <td>{{ $order['customer'] }}</td>
            <td><x-widget.table.badge :tone="['paid' => 'success', 'pending' => 'warning', 'refunded' => 'info', 'failed' => 'error'][$order['status']]">{{ $order['status_label'] }}</x-widget.table.badge></td>
            <td>{{ $order['payment_label'] }}</td>
            <td>{{ $order['date_label'] }}</td>
            <td>{{ $order['amount'] }}</td>
        </x-widget.table.row>
    @endforeach

    <x-slot:footer>
        <tr>
            <td>{{ $totals['count'] }} {{ $totals['count'] === 1 ? 'order' : 'orders' }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $totals['amount'] }}</td>
        </tr>
    </x-slot:footer>
</x-widget.table>
