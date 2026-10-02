{{-- length sets how many characters it takes (6 by default); anything past it is dropped. alphanumeric takes letters as well as digits, for backup and invite codes. --}}
<div class="grid gap-6 sm:grid-cols-3">
    <x-widget.verification-code name="pin" label="4-digit PIN" :length="4" />
    <x-widget.verification-code name="sms_code" label="8-digit code" :length="8" />
    <x-widget.verification-code name="backup_code" label="Backup code" :length="8" alphanumeric />
</div>
