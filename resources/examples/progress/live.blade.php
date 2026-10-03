{{-- progress.set() moves the bar and updates what screen readers hear in one call; the script beside this calls it as the import goes. An indeterminate bar turns into a normal one on the first set(). --}}
<div class="flex w-full flex-col gap-5">
    <x-widget.progress id="upload-progress" indeterminate label="Uploading report.pdf" show-label />
    <x-widget.progress id="file-progress" :max="5" value-text="0 of 5 files" label="Importing" show-label label-position="beside" />

    <div>
        <button
            type="button"
            class="bg-primary-fill text-on-primary hover:bg-primary-hover focus-visible:ring-primary rounded-xl px-4 py-2.5 text-sm font-medium outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
            data-start-import
        >Start</button>
    </div>
</div>
