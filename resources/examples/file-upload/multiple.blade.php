{{-- multiple with max-files: each file joins the list with its size and a remove button, and a file that's too big or the wrong type is listed with the reason instead of being added. The form sends the files still in the list. --}}
<form method="POST" enctype="multipart/form-data" class="max-w-xl">
    @csrf
    <x-widget.file-upload name="attachments[]" label="Attachments" multiple max-files="5" accept="image/*,.pdf" max-size="10MB" />
</form>
