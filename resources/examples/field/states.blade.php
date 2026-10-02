{{-- An error, as from $errors->get(): one message or several. It clears the moment the value changes. --}}
<div class="grid gap-6 sm:grid-cols-2">
    <x-widget.field id="handle" label="Handle" error="That handle is taken." required>
        <input id="handle" name="handle" value="larawell" required aria-invalid="true" aria-describedby="handle-error" class="w-full bg-transparent px-4 outline-none">
    </x-widget.field>

    <x-widget.field id="bio" label="Bio" box="items-start" counter="160" count="0">
        <textarea id="bio" name="bio" maxlength="160" rows="3" class="w-full resize-none bg-transparent px-4 py-3 outline-none"></textarea>
    </x-widget.field>
</div>
