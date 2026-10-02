{{-- Compact: a button and the chosen file's name, for tight forms and table rows. Same accept and max-size checks as the dropzone. --}}
<form method="POST" enctype="multipart/form-data">
    @csrf
    <x-widget.file-upload.button name="import" label="Import contacts" accept=".csv" max-size="2MB" button-label="Choose CSV" />
</form>
