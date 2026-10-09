// The URL in children-url answers GET with the node's children as HTML: tree items, inside a tree of the same look
// (variant), so each renders that look's styles. The script takes the items out and leaves the tree behind. Give a
// child that has children of its own its own children-url; one with none left off is a leaf. Check the person may see
// this member, as for any page.
Route::get('/members/{member}/children', function (Member $member) {
    Gate::authorize('view', $member);

    return view('members.children', ['children' => $member->referrals()->withCount('referrals')->orderBy('joined_at')->get()]);
})->name('members.children');

// resources/views/members/children.blade.php
<x-widget.tree variant="cards">
    @foreach ($children as $child)
        <x-widget.tree.item
            :label="$child->username"
            :meta="'Level '.$child->level"
            :children-url="$child->referrals_count > 0 ? route('members.children', $child) : null"
        >
            <x-slot:details>Joined {{ $child->joined_at->isoFormat('D MMM YYYY') }} · Team of {{ $child->referrals_count }}</x-slot:details>
        </x-widget.tree.item>
    @endforeach
</x-widget.tree>
