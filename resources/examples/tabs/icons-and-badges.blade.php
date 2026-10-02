{{-- A tab can be an array: an icon before its label, a badge after it (a count), or disabled, which the arrow keys skip. variant="tinted" underlines the open tab and puts it on a light wash of the primary colour, like the vertical tabs. --}}
<x-widget.tabs id="mailbox" label="Mailbox" variant="tinted" :tabs="[
    'inbox' => ['label' => 'Inbox', 'icon' => 'inbox', 'badge' => 12],
    'drafts' => ['label' => 'Drafts', 'icon' => 'pencil', 'badge' => 2],
    'archive' => ['label' => 'Archive', 'icon' => 'file'],
    'spam' => ['label' => 'Spam', 'icon' => 'triangle-alert', 'disabled' => true],
]">
    <x-slot:inbox>12 unread messages.</x-slot:inbox>
    <x-slot:drafts>2 drafts.</x-slot:drafts>
    <x-slot:archive>Everything you've filed away.</x-slot:archive>
    <x-slot:spam>Nothing here.</x-slot:spam>
</x-widget.tabs>
