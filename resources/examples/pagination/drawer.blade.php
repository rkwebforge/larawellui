{{-- The default. Tapping the current page opens a bottom sheet listing every page, built only when it first opens. Pass any paginator, e.g. Order::query()->paginate(10) from your controller. --}}
<x-widget.pagination :paginator="$orders" />
