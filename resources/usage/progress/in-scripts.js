// window.progress is available once the progress script has loaded.
// <x-widget.progress id="upload" label="Uploading" show-label />
progress.set('upload', 60);

// Value out of the bar's max, with your own wording (also what screen readers hear).
// <x-widget.progress id="files" :max="5" label="Files" show-label />
progress.set('files', 3, { text: '3 of 5 files' });

// e.g. from an upload's progress event
request.upload.addEventListener('progress', (event) => {
    progress.set('upload', (event.loaded / event.total) * 100);
});
