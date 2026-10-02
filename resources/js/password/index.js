// Behaviour for <x-widget.password>: the show/hide toggle, the Caps Lock warning and the checklist of rules. Delegated from `document`, so fields added later work without
// re-initialising. Client-side filtering is only for convenience; the Form Request must validate the same rules.
import { on, onLivewireMorph } from '../field';

// --- Password: show/hide toggle -------------------------------------------------

on('click', '[data-password-toggle]', (event, button) => {
    const input = document.getElementById(button.getAttribute('aria-controls'));
    const show = input.type === 'password';

    input.type = show ? 'text' : 'password';
    // A toggle button keeps one name ("Show password") and says its state with aria-pressed. Swapping the
    // name as well would read "Hide password, pressed", which contradicts itself.
    button.setAttribute('aria-pressed', String(show));
    button.querySelector('[data-icon-show]').classList.toggle('hidden', show);
    button.querySelector('[data-icon-hide]').classList.toggle('hidden', !show);
});

// --- Password: Caps Lock warning --------------------------------------------------

const capsLockHint = (input) => input.closest('[data-field]').querySelector('[data-caps-lock]');

['keydown', 'keyup'].forEach((type) => on(type, '[data-password-input]', (event, input) => {
    // getModifierState is missing on some synthetic events (autofill); leave the hint as it was.
    if (typeof event.getModifierState === 'function') {
        const hint = capsLockHint(input);
        hint.textContent = event.getModifierState('CapsLock') ? hint.dataset.message : '';
    }
}));
on('focusout', '[data-password-input]', (event, input) => {
    capsLockHint(input).textContent = '';
});

// --- Password: requirements checklist (new) ----------------------------------------------

// The same tests as Laravel's Password rule, character classes included, so a password that ticks every
// box here passes on the server. min counts characters, like the rule's min:.
const PASSWORD_RULES = {
    min: (value, item) => [...value].length >= Number(item.dataset.min),
    letters: (value) => /\p{L}/u.test(value),
    mixedCase: (value) => /(\p{Ll}+.*\p{Lu})|(\p{Lu}+.*\p{Ll})/u.test(value),
    numbers: (value) => /\p{N}/u.test(value),
    symbols: (value) => /\p{Z}|\p{S}|\p{P}/u.test(value),
};

function updatePasswordRules(input) {
    input.closest('[data-field]').querySelectorAll('[data-password-rule]').forEach((item) => {
        const met = PASSWORD_RULES[item.dataset.passwordRule]?.(input.value, item) ?? false;
        item.toggleAttribute('data-met', met);
        item.querySelector('[data-password-rule-status]').textContent = met ? ', done' : '';
    });
}

on('input', '[data-password-input]', (event, input) => updatePasswordRules(input));

// Livewire: a render brings back the server's markup, so the checklist follows the value again.
onLivewireMorph((scope) => scope.querySelectorAll('[data-password-input]').forEach(updatePasswordRules));
