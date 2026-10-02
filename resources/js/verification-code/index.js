// Behaviour for <x-widget.verification-code>: digits (or letters) only, up to the length. Delegated from `document`, so fields added later work without
// re-initialising. Client-side filtering is only for convenience; the Form Request must validate the same rules.
import { on, replaceValue } from '../field';

// --- Verification code: single field, fixed length --------------------------------

on('input', '[data-code-input]', (event, input) => {
    const disallowed = input.dataset.codeInput === 'alphanumeric' ? /[^a-zA-Z0-9]/g : /\D/g;
    replaceValue(input, input.value.replace(disallowed, '').slice(0, Number(input.dataset.length)));
});
