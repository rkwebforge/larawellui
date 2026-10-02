{{-- Each button names a toast method, and the script beside this calls it. Needs <x-widget.toast /> once in your layout; see Usage. --}}
<div class="flex flex-wrap gap-2">
    <button type="button" class="bg-field rounded-full px-4 py-2 text-sm" data-notify="success">Success</button>
    <button type="button" class="bg-field rounded-full px-4 py-2 text-sm" data-notify="error">Error</button>
    <button type="button" class="bg-field rounded-full px-4 py-2 text-sm" data-notify="warning">Warning</button>
    <button type="button" class="bg-field rounded-full px-4 py-2 text-sm" data-notify="loading">Loading, then success</button>
    <button type="button" class="text-foreground rounded-full px-4 py-2 text-sm underline underline-offset-4" data-notify="dismiss">Dismiss all</button>
</div>
