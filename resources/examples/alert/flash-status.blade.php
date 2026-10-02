{{-- flash="status" shows session('status') when there is one and nothing otherwise, so it can live in your layout. Laravel's auth screens flash under status; see Usage. It's announced to screen readers, as a message after an action should be. --}}
<x-widget.alert flash="status" tone="success" dismissible class="max-w-2xl" />
