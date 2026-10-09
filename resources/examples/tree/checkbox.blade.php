{{-- variant="checkbox": a tick box on every node. Ticking a parent ticks everything under it, and a parent with only some ticked shows a dash. The values of ticked nodes submit as name[] (here permissions[]); a node without a value only groups. value sets what starts ticked; disabled keeps a node as it is. Space ticks, Enter too. --}}
<x-widget.tree label="Permissions" variant="checkbox" name="permissions" :value="['posts.view', 'posts.create', 'users.view']" info="Delete is managed by the owner." class="max-w-sm">
    <x-widget.tree.item label="Posts" open>
        <x-widget.tree.item label="View" value="posts.view" />
        <x-widget.tree.item label="Create" value="posts.create" />
        <x-widget.tree.item label="Edit" value="posts.edit" />
        <x-widget.tree.item label="Delete" value="posts.delete" disabled />
    </x-widget.tree.item>
    <x-widget.tree.item label="Users" open>
        <x-widget.tree.item label="View" value="users.view" />
        <x-widget.tree.item label="Invite" value="users.invite" />
    </x-widget.tree.item>
    <x-widget.tree.item label="Settings" value="settings" />
</x-widget.tree>
