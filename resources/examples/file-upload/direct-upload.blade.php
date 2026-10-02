{{-- upload-url sends each file to your route as soon as it's picked, with a progress bar and retry. The route stores it and returns its id, and the form submits the ids, not the files. Submitting waits for uploads still running. Uses an uploads.store route from your app; see Usage for it. --}}
<form method="POST" class="max-w-xl">
    @csrf
    <x-widget.file-upload name="documents[]" label="Documents" multiple :upload-url="route('uploads.store')" max-size="10MB" />
</form>
