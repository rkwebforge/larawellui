{{-- suggestions lists tags the browser offers as people type; any other text can still be added. max caps how many: past it, typing more is refused and a screen reader hears why. --}}
<x-widget.tags name="skills" label="Skills" placeholder="Add a skill" :suggestions="['Laravel', 'Livewire', 'Tailwind CSS', 'PHP', 'JavaScript', 'MySQL', 'Redis']" :max="5" info="Up to five." class="max-w-md" />
