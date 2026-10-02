{{-- Panels that share a name close each other, so only one answer is open at a time. --}}
<div class="flex flex-col gap-2">
    <x-widget.accordion name="faq" title="How long does a withdrawal take?" open>
        Most withdrawals complete within 30 minutes. Network congestion can add delays.
    </x-widget.accordion>
    <x-widget.accordion name="faq" title="Which networks are supported?">
        TRC20, ERC20 and BEP20. Always check the network before sending funds.
    </x-widget.accordion>
    <x-widget.accordion name="faq" title="Why was my transaction declined?">
        Common reasons are an incorrect address, insufficient balance or a daily limit.
    </x-widget.accordion>
</div>
