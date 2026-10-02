{{-- loading draws placeholder rows while data is on its way, e.g. during a Livewire or fetch request, and tells screen readers it's loading. --}}
<x-widget.table caption="Customers" loading :skeleton-rows="4" :columns="['Name', 'Email', 'Plan', ['label' => 'Spend', 'align' => 'end']]" />
