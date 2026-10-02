{{-- The dialog scrolls as a whole while the page behind it stays locked. --}}
<x-widget.button variant="neutral" data-modal-open="terms-of-service">Read the terms</x-widget.button>

<x-widget.modal id="terms-of-service" title="Terms of service" size="lg">
    <div class="text-foreground/75 flex flex-col gap-6 text-sm leading-relaxed">
        @foreach ([
            'Who these terms cover' => [
                'These terms are an agreement between you and us. They apply whenever you open an account, add money, send a transfer or receive one, whether you use the website, the mobile app or the API.',
                'By creating an account you confirm that you are at least 18 years old and that the details you give us are true and complete. If you use the service for a business, you confirm you are allowed to accept these terms on its behalf.',
            ],
            'Opening your account' => [
                'We are required by law to check who you are before you can send money. We may ask for a photo ID, proof of address and, for larger amounts, where the money came from. Until these checks are complete, some features stay limited.',
                'You may hold one personal account. Accounts opened with someone else\'s details, or to get around a limit or a closure, will be closed without notice.',
            ],
            'Keeping your account safe' => [
                'Keep your password and verification codes to yourself. We will never ask for them by email, text or phone. Turn on two-step verification and keep your email address and phone number up to date.',
                'Tell us straight away if you think someone else has accessed your account or if your device is lost or stolen. You will not be responsible for transfers made after you tell us, unless you acted fraudulently.',
            ],
            'Sending money' => [
                'Before you confirm a transfer we show you the amount, the fee, the exchange rate and when the money should arrive. Check the recipient\'s details carefully: once a transfer has been paid out, we may not be able to get it back.',
                'Most transfers arrive within one working day. Some take longer because of the recipient\'s bank, public holidays or extra checks we must carry out. We will keep you updated in the app while a transfer is in progress.',
                'You can cancel a transfer free of charge until the money has been sent to the recipient. After that, cancelling is only possible if the recipient\'s bank agrees to return the funds.',
            ],
            'Fees and exchange rates' => [
                'Our fees are listed on the pricing page and are always shown before you confirm. We never hide a margin in the exchange rate: the rate you see is the rate you get, for as long as the quote is valid.',
                'If a quote expires before your money reaches us, we will offer a new one. You can accept it or ask for a full refund.',
            ],
            'Limits' => [
                'Daily and monthly limits depend on your country, the currency and how much we have verified about you. You can see your current limits in account settings and ask us to raise them.',
            ],
            'Things you must not do' => [
                'You must not use the service for anything illegal, to receive money from fraud, or to pay for goods and services that are prohibited in your country or ours. You must not try to interfere with the service or access other people\'s accounts.',
                'If we suspect any of this, we may delay or block a transfer, freeze your balance while we investigate and report it to the authorities where the law requires us to.',
            ],
            'Closing your account' => [
                'You can close your account at any time from account settings once any transfers in progress have finished. We will send the remaining balance to a bank account in your name.',
                'We may close your account with two months\' notice, or immediately if you break these terms or the law requires it. We keep your records for as long as the law requires after the account closes.',
            ],
            'Complaints' => [
                'If something goes wrong, contact us through the help centre and we will reply within 15 working days. If you are not happy with our answer, you may be able to take your complaint to an independent ombudsman.',
            ],
            'Changes to these terms' => [
                'We may update these terms from time to time. We will email you at least two months before a change affects you. If you do not agree, you can close your account for free before the change takes effect.',
            ],
        ] as $heading => $paragraphs)
            <section class="flex flex-col gap-2">
                <h3 class="text-foreground text-base font-semibold">{{ $loop->iteration }}. {{ $heading }}</h3>
                @foreach ($paragraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </section>
        @endforeach
    </div>
</x-widget.modal>
