{{-- The default: text tabs on a rule. Each tab's panel is the named slot of its key. The arrow keys move between tabs, Home and End jump to the ends, and only the open tab is in the Tab order. --}}
<x-widget.tabs id="account" label="Account" :tabs="['profile' => 'Profile', 'security' => 'Security', 'notifications' => 'Notifications']">
    <x-slot:profile>Your name, photo and the email we write to.</x-slot:profile>
    <x-slot:security>Password, two-factor authentication and signed-in devices.</x-slot:security>
    <x-slot:notifications>What we email you about, and how often.</x-slot:notifications>
</x-widget.tabs>
