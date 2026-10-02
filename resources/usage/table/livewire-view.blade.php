{{-- The view for that component. Pass :sort and :direction from the component. Fields in the filters slot are yours to bind with wire:model; Livewire filters in place, and the empty state's Clear filters resets every bound field. Give each row a wire:key, so open rows and ticks stay with their record when the component re-renders. --}}
<div>
    <x-widget.table
        id="invoices"
        caption="Invoices"
        :rows="$invoices"
        :columns="[
            ['label' => 'Number', 'key' => 'number', 'sortable' => true],
            ['label' => 'Date', 'key' => 'date', 'sortable' => true],
            ['label' => 'Amount', 'key' => 'amount', 'sortable' => true, 'align' => 'end'],
        ]"
        :sort="$sort"
        :direction="$direction"
        selectable
        select-model="selected"
        pagination="footer"
        per-page-model="perPage"
    >
        <x-slot:filters>
            <x-widget.search name="search" wire:model.live.debounce.300ms="search" placeholder="Search invoices" />
        </x-slot:filters>

        <x-slot:bulk>
            <x-widget.button type="button" variant="danger" size="sm" wire:click="deleteSelected" wire:confirm="Delete the selected invoices?">Delete</x-widget.button>
        </x-slot:bulk>

        @foreach ($invoices as $invoice)
            <x-widget.table.row wire:key="invoice-{{ $invoice->id }}" :value="$invoice->id" :select-label="'Select '.$invoice->number">
                <td>{{ $invoice->number }}</td>
                <td>{{ $invoice->date->toFormattedDateString() }}</td>
                <td>{{ $invoice->amount }}</td>
            </x-widget.table.row>
        @endforeach
    </x-widget.table>
</div>
