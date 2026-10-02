{{-- "Showing 11 to 20 of 470 results" with labelled Previous and Next buttons. Clear at any width, and works with simplePaginate() too (the total is left out). Pass any paginator, e.g. Order::query()->paginate(10) from your controller. --}}
<x-widget.pagination type="summary" :paginator="$orders" />
