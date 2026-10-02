{{-- Inside a Livewire component the text updates with each render, a showing one keeps following the pointer, and it stays linked to its element for screen readers. --}}
<div class="flex h-40 items-end gap-2" wire:poll.10s="refresh">
    @foreach ($days as $day)
        <x-widget.tooltip-cursor wire:key="day-{{ $day->date }}" :text="$day->label.': '.$day->orders.' orders'" class="h-full flex-1 items-end">
            {{-- your bar --}}
        </x-widget.tooltip-cursor>
    @endforeach
</div>
