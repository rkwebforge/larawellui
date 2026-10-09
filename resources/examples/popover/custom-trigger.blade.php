{{-- A trigger slot takes your own markup: here a name and initials. Keep links and buttons out of it, since the trigger is one button; they go in the panel. width sets the panel's width: sm, md or lg. --}}
<x-widget.popover label="Amelia Chen's profile" width="sm" align="start">
    <x-slot:trigger>
        <span class="bg-primary/10 text-primary grid size-9 place-items-center rounded-full text-sm font-semibold" aria-hidden="true">AC</span>
        <span class="text-sm font-medium">Amelia Chen</span>
    </x-slot:trigger>

    <p class="font-semibold">Amelia Chen</p>
    <p class="text-foreground/70 text-xs">Finance lead · Singapore</p>
    <div class="mt-3 flex flex-col gap-1">
        <a href="#profile" class="text-link hover:text-link-hover underline-offset-4 hover:underline">View profile</a>
        <a href="#message" class="text-link hover:text-link-hover underline-offset-4 hover:underline">Send a message</a>
    </div>
</x-widget.popover>
