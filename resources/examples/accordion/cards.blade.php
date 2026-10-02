{{-- variant="card": each item is its own card, which suits settings and grouped forms. --}}
<div class="flex flex-col gap-3">
    <x-widget.accordion variant="card" title="Notifications" open>
        Email me when a withdrawal completes, fails, or needs another check.
    </x-widget.accordion>
    <x-widget.accordion variant="card" title="Security">
        Two-factor authentication is on. You signed in from 2 devices this month.
    </x-widget.accordion>
</div>
