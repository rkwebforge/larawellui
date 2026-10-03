{{-- A deep trail wraps onto a second line, and a long label is cut short with the full text in its tooltip. --}}
<x-widget.breadcrumbs class="max-w-md" :items="[
    ['label' => 'Home', 'href' => '#', 'icon' => 'home'],
    ['label' => 'Projects', 'href' => '#'],
    ['label' => 'Website redesign for the spring campaign', 'href' => '#'],
    ['label' => 'Files', 'href' => '#'],
    'homepage-hero-final-v3.png',
]" />
