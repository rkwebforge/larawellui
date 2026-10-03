// Drives <x-widget.show-if>: shows or hides its fieldset as the field it follows changes. Hidden, the fieldset is also
// inert and disabled, so what's in it can't be reached and doesn't submit. Delegated from `document`, so fields and
// show-ifs added later (fetched HTML, a modal's content) work without setting up.
import { onLivewireMorph } from '../field';

const ROOT = '[data-show-if]';

// What the field holds now: the ticked boxes' and chosen radio's values, a select's chosen options, or what's typed in.
// A field that is itself hidden and disabled holds nothing, so a show-if that follows it hides too.
function valuesOf(scope, name) {
    const controls = scope.querySelectorAll(`[name="${CSS.escape(name)}"], [name="${CSS.escape(name.replace(/\[\]$/, ''))}[]"]`);

    return [...controls].filter((control) => !control.matches(':disabled')).flatMap((control) => {
        if (control.type === 'checkbox' || control.type === 'radio') {
            return control.checked ? [control.value] : [];
        }
        if (control instanceof HTMLSelectElement) {
            return [...control.selectedOptions].map((option) => option.value);
        }

        return [control.value];
    }).filter((value) => value !== '');
}

// Shows or hides one show-if; returns whether it changed.
function update(root) {
    const expected = root.dataset.showValue ? JSON.parse(root.dataset.showValue) : null;
    const current = valuesOf(root.form ?? root.closest('form') ?? document, root.dataset.showIf);
    const show = expected ? current.some((value) => expected.includes(value)) : current.length > 0;
    if (show === !root.hidden) {
        return false;
    }
    root.hidden = !show;
    root.inert = !show;
    root.disabled = !show;

    return true;
}

// Every show-if in a scope, again until nothing changes: one can follow a field inside another, which a change shows or
// hides in turn.
function updateAll(scope = document) {
    const roots = [...scope.querySelectorAll(ROOT)];
    for (let pass = 0; pass < 10 && roots.map(update).some(Boolean); pass++) {
        // Keep going while something changed.
    }
}

const scopeOf = (element) => element.closest?.('form') ?? document;

document.addEventListener('input', (event) => updateAll(scopeOf(event.target)));
document.addEventListener('change', (event) => updateAll(scopeOf(event.target)));
// form.reset() puts the fields back after the event, without input or change events of its own.
document.addEventListener('reset', (event) => setTimeout(() => updateAll(scopeOf(event.target))));

// The server drew the starting state; this catches what the browser changed before the script ran (a field it filled
// back in on Back), and a Livewire render, which puts back the server's markup.
updateAll();
onLivewireMorph(() => updateAll());
