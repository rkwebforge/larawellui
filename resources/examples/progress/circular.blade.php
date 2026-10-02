{{-- indeterminate spins for work with no known end. --}}
<div class="flex flex-wrap items-end gap-8">
    <x-widget.progress.circular :value="35" label="Uploading" show-label />
    <x-widget.progress.circular :value="100" label="Verified" show-label />
    <x-widget.progress.circular :value="60" label="Failed" show-label failed />
    <x-widget.progress.circular indeterminate label="Loading" show-label />
    <x-widget.progress.circular :value="85" size="lg" label="Large" show-label />
</div>
