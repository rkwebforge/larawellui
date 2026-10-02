{{-- The label can be a slot, for links. After a failed submit, the box keeps the state the user left it in. unchecked-value="0" sends a value when it's off, for boolean columns. --}}
<div class="flex flex-col gap-4">
    <x-widget.checkbox name="terms" required>
        I agree to the <a href="#terms" class="text-link underline">terms of service</a>
    </x-widget.checkbox>
    <x-widget.checkbox name="newsletter" label="Email me product news" description="About once a month. Unsubscribe any time." unchecked-value="0" checked />
</div>
