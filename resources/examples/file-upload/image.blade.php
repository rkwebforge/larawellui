{{-- A profile photo or logo: pass the current one as src, pick a new one to preview it, or remove it. remove-name submits remove_avatar=1 when the current photo is removed. shape="square" suits logos; size is sm, md or lg. The preview needs img-src blob: in a Content Security Policy. --}}
<form method="POST" enctype="multipart/form-data" class="flex flex-wrap gap-10">
    @csrf
    <x-widget.file-upload.image name="avatar" label="Profile photo" max-size="2MB" remove-name="remove_avatar" />
    <x-widget.file-upload.image name="logo" label="Company logo" shape="square" size="lg" accept="image/png,image/svg+xml" max-size="1MB" />
</form>
