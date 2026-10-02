{{-- One bar per step. Pass a count with :total, or the step names with :steps to show where the user is. --}}
<div class="flex w-full max-w-md flex-col gap-6">
    <x-widget.stepper :total="4" :current="2" label="Verification" />
    <x-widget.stepper :steps="['Cart', 'Shipping', 'Payment', 'Review']" :current="2" label="Checkout" show-label show-steps />
    <x-widget.stepper :total="5" :current="4" label="Profile setup" show-label />
</div>
