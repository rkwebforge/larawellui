{{-- size sets the height, matching the button and field sizes: sm (32px) beside compact controls, md (48px, the default) beside form fields. The width is the layout's: the box fills its container, so narrow it with a class such as max-w-xs. The × clears the text. --}}
<div class="flex flex-col gap-4">
    <x-widget.search name="find" placeholder="Search transactions" />
    <x-widget.search name="find_small" placeholder="Small search" size="sm" />
    <x-widget.search name="find_narrow" placeholder="Narrow search" class="max-w-xs" />
</div>
