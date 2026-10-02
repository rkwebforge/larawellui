<div class="grid gap-5 sm:grid-cols-2">
    <x-widget.progress :value="35" label="Uploading documents" show-label />
    <x-widget.progress :value="100" label="Verification" show-label />
    <x-widget.progress :value="60" label="Withdrawal failed" show-label failed />
    <x-widget.progress :value="40" label="Paused" show-label disabled />
</div>
