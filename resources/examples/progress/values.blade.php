{{-- :max makes progress "value out of max" in your own units, and value-text says it in words: shown instead of the percentage and read out by screen readers. label-position puts the label above, beside or inside the bar. --}}
<div class="flex w-full flex-col gap-5">
    <x-widget.progress :value="3" :max="5" value-text="3 of 5 files" label="Uploading" show-label />
    <x-widget.progress :value="1.2" :max="5" value-text="1.2 GB of 5 GB" label="Storage" show-label label-position="beside" />
    <x-widget.progress :value="750" :max="1000" value-text="$750 of $1,000" label="Raised" show-label label-position="inside" />
</div>
