{{-- From the top down; the last is the page you're on. Make the browser window narrow to see the phone version: one link back up. --}}
<x-widget.breadcrumbs :items="[
    ['label' => 'Home', 'href' => '#'],
    ['label' => 'Orders', 'href' => '#'],
    'Order #1042',
]" />
