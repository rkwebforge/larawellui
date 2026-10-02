{{-- In a GET form, Enter submits and the page reloads with ?q=…; the box fills itself back in from the query string, so the results can be shared and bookmarked. That's all it does on its own. To search as you type without a reload, put it in a table's filters slot, or bind it with wire:model.live in Livewire. --}}
<form method="GET" role="search" class="flex max-w-md items-center gap-2">
    <x-widget.search name="q" placeholder="Search the help centre" label="Search the help centre" />
    <button type="submit" class="bg-primary text-on-primary focus-visible:ring-primary h-12 shrink-0 rounded-[20px] px-5 text-sm font-medium outline-none focus-visible:ring-2 focus-visible:ring-offset-2">Search</button>
</form>
