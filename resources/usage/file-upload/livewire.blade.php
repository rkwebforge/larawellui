{{-- In a Livewire component that uses WithFileUploads, bind with wire:model; no name is needed. Each file goes to Livewire's temporary uploads as it's picked or dropped, and removing one from the list removes it from the property, so it always holds exactly what the list shows: one file, or an array with multiple. The list, name and preview survive every render; reset the property after saving ($this->reset('photo')) and they empty too. Livewire's livewire-upload-start, -progress and -finish events fire on the input. Not with upload-url, which sends files to your own route instead. --}}
<form wire:submit="save" class="space-y-6">
    <x-widget.file-upload label="Attachments" multiple max-size="10MB" wire:model="attachments" />

    <x-widget.file-upload.image label="Photo" :src="$user->avatar_url" wire:model="photo" />

    <button type="submit">Save</button>
</form>
