{{-- One file: drag it onto the area or click to browse. accept and max-size are checked as soon as it's picked, and say themselves in the hint; the Form Request checks them again (see Usage). Without JavaScript it's a plain file input. --}}
<form method="POST" enctype="multipart/form-data" class="max-w-xl">
    @csrf
    <x-widget.file-upload name="contract" label="Signed contract" accept=".pdf" max-size="5MB" required />
</form>
