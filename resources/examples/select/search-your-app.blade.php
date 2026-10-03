{{-- For lists too long to send to the page (customers, products), search-url asks your app as you type and shows what it answers. Pass the chosen one in options, so the field shows it before any search. Try "an", or part of an email. --}}
<x-widget.select name="customer_id" label="Customer" placeholder="Choose a customer" class="max-w-md"
    search-url="{{ route('customers.search') }}"
    value="7"
    :options="[['value' => 7, 'label' => 'Ana Silva', 'meta' => 'ana@example.com']]" />
