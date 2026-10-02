{{-- In a Livewire component, bind with wire:model (deferred) or wire:model.live.debounce for live checks; no name is needed. The text shows the property after every render, the counter and height included, so clearing it in PHP after a save empties the box. --}}
<form wire:submit="post" class="space-y-5">
    <x-widget.textarea label="Comment" counter maxlength="500" wire:model="comment" />

    <button type="submit">Post</button>
</form>
