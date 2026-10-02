{{-- Pick the country, type the number as it's dialled at home. It submits one international number (+60123456789): validate it on the server, for example with propaganistas/laravel-phone. Pasting a full +44 number switches the country. country sets where it starts; otherwise the app locale's region does. --}}
<div class="grid gap-6 sm:grid-cols-2">
    <x-widget.phone name="mobile" label="Mobile number" country="MY" placeholder="12-345 6789" required />
    <x-widget.phone name="office" label="Office" value="+442079460958" />
</div>
