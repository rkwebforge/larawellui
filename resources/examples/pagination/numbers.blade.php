{{-- First, last, the current page and its neighbours, with gaps shown as an ellipsis. Pass any paginator, e.g. Order::query()->paginate(10) from your controller. --}}
<x-widget.pagination type="numbers" :paginator="$orders" />
