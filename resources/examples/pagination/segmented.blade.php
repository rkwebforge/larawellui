{{-- The numbers style as one joined, bordered group with the current page filled. A boxier look for admin screens. Pass any paginator, e.g. Order::query()->paginate(10) from your controller. --}}
<x-widget.pagination type="segmented" :paginator="$orders" />
