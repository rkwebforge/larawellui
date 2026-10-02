{{-- In a Livewire component, pass the value from a property and every render redraws the bar: after an action, or on wire:poll while a job runs. A bar you drive from JavaScript with progress.set() instead, such as from Livewire's upload progress events, goes in a wire:ignore, or the next render puts back the server's value. --}}
<div wire:poll.1s="refreshExport" class="space-y-6">
    <x-widget.progress :value="$export->processed" :max="$export->total" label="Exporting" show-label :value-text="$export->processed.' of '.$export->total.' rows'" />
</div>

<div x-on:livewire-upload-progress="progress.set('upload', $event.detail.progress)" class="space-y-3">
    <x-widget.file-upload label="Video" wire:model="video" />
    <div wire:ignore>
        <x-widget.progress id="upload" label="Uploading" show-label />
    </div>
</div>
