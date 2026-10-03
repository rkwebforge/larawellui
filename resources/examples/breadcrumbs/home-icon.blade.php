{{-- iconOnly shows Home as an icon alone, still named "Home" for screen readers. separator="slash" for a lighter look. --}}
<x-widget.breadcrumbs separator="slash" :items="[
    ['label' => 'Home', 'href' => '#', 'icon' => 'home', 'iconOnly' => true],
    ['label' => 'Settings', 'href' => '#'],
    'Billing',
]" />
