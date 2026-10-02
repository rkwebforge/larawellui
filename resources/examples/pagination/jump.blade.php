{{-- Previous and next, plus a field to go straight to a page. Suits very long lists. Pass any paginator, e.g. Order::query()->paginate(10) from your controller. --}}
<x-widget.pagination type="jump" :paginator="$orders" />
