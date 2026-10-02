{{-- icon-position="start" puts the magnifier before the text. value fills it in (the query string wins, when it has one); :clearable="false" leaves out the × button. --}}
<div class="flex flex-col gap-4">
    <x-widget.search name="team" placeholder="Search people" icon-position="start" />
    <x-widget.search name="team_fixed" value="Design" icon-position="start" :clearable="false" size="sm" class="max-w-xs" />
</div>
