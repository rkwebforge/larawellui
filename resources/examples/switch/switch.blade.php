{{-- A checkbox with role="switch", so screen readers announce on and off. It submits like a checkbox. --}}
<div class="divide-line flex max-w-md flex-col divide-y">
    <x-widget.switch name="alerts" label="Withdrawal alerts" description="Email me when a withdrawal completes." checked class="py-3" />
    <x-widget.switch name="two_factor" label="Two-factor authentication" class="py-3" />
    <x-widget.switch name="beta" label="Beta features" disabled class="py-3" />
</div>
