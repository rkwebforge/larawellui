{{-- With href on every tab they're links to other pages, in a nav, with the current one marked (aria-current="page"). There are no panels: each page is its own. value says which page this is. --}}
<x-widget.tabs id="project" label="Project" value="settings" :tabs="[
    'overview' => ['label' => 'Overview', 'href' => '#overview'],
    'issues' => ['label' => 'Issues', 'href' => '#issues', 'badge' => 4],
    'settings' => ['label' => 'Settings', 'href' => '#settings'],
]" />
