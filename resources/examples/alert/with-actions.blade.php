{{-- The actions slot holds links or buttons that act on the message. --}}
<x-widget.alert tone="warning" title="Your trial ends in 3 days" class="max-w-2xl">
    Add a card to keep your projects running after 30 September.
    <x-slot:actions>
        <a href="#billing" class="text-foreground underline underline-offset-4">Add a card</a>
        <a href="#plans" class="text-foreground/70 hover:text-foreground">Compare plans</a>
    </x-slot:actions>
</x-widget.alert>
