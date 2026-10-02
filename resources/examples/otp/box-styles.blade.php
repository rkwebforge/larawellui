{{-- variant is filled (default), outline or underline. group="3" adds a dash between groups of boxes. masked shows dots, for a PIN. alphanumeric takes letters too, shown in capitals. length sets how many boxes. --}}
<div class="grid gap-8 sm:grid-cols-2">
    <x-widget.otp name="otp_outline" label="Outline, grouped" variant="outline" group="3" />
    <x-widget.otp name="otp_underline" label="Underline" variant="underline" placeholder="" />
    <x-widget.otp name="pin" label="PIN" :length="4" masked placeholder="" class="max-w-60" />
    <x-widget.otp name="invite" label="Invite code" alphanumeric variant="outline" placeholder="" />
</div>
