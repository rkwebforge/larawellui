{{-- remember keeps the open tab in the URL (#plans=team), so sharing the link, reloading or going Back opens it again. Several sets on one page share the hash. --}}
<x-widget.tabs id="plans" label="Plans" variant="pills" remember :tabs="['personal' => 'Personal', 'team' => 'Team', 'enterprise' => 'Enterprise']">
    <x-slot:personal>For one person: unlimited projects.</x-slot:personal>
    <x-slot:team>For up to 50 people: shared projects and roles.</x-slot:team>
    <x-slot:enterprise>For larger companies: SSO, audit log and support.</x-slot:enterprise>
</x-widget.tabs>
