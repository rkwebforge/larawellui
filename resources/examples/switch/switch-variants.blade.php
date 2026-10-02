{{-- size is sm, md (default) or lg. icons puts a tick or cross in the knob, so on and off don't rely on colour alone. placement="start" puts the switch before the text, like a checkbox. variant="card" makes the whole row a tile that lights up while on. --}}
<div class="flex flex-col gap-8">
    <div class="flex flex-col gap-4">
        <x-widget.switch name="compact" label="Small" size="sm" checked icons placement="start" />
        <x-widget.switch name="default_size" label="Medium" checked icons placement="start" />
        <x-widget.switch name="large" label="Large" size="lg" icons placement="start" />
    </div>

    <div class="grid gap-3 sm:grid-cols-2">
        <x-widget.switch name="addons[]" value="backup" label="Daily backups" description="Kept for 30 days" variant="card" checked />
        <x-widget.switch name="addons[]" value="support" label="Priority support" description="Replies within 2 hours" variant="card" />
    </div>
</div>
