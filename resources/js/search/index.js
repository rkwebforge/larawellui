// Behaviour for <x-widget.search>: the clear button and the keyboard shortcut. Delegated from `document`, so fields added later work without
// re-initialising. Client-side filtering is only for convenience; the Form Request must validate the same rules.
import { on } from '../field';

// --- Search: the clear button ----------------------------------------------------------

// Empties the box and tells listeners, as deleting the text would: a table's filters refilter, wire:model updates.
// Showing and hiding the button is CSS (see search.blade.php).
on('click', '[data-search-clear]', (event, button) => {
    const input = document.getElementById(button.getAttribute('aria-controls'));
    if (!input || input.value === '') {
        return;
    }
    input.value = '';
    input.dispatchEvent(new Event('input', { bubbles: true }));
    input.dispatchEvent(new Event('change', { bubbles: true }));
    input.focus();
});

// shortcut="/": the key jumps to the box, unless you're typing somewhere else or a dialog is open over it (then only
// a box inside that dialog counts). The first visible box with that key wins.
document.addEventListener('keydown', (event) => {
    if (event.defaultPrevented || event.ctrlKey || event.metaKey || event.altKey || event.key.length !== 1) {
        return;
    }
    const target = event.target;
    if (target instanceof Element && target.closest('input, textarea, select, [contenteditable]:not([contenteditable="false"])')) {
        return;
    }
    const dialog = document.querySelector('dialog[open]');
    const box = [...document.querySelectorAll('[data-search-shortcut]')].find((input) => input.dataset.searchShortcut.toLowerCase() === event.key.toLowerCase()
        && input.offsetParent !== null && (!dialog || dialog.contains(input)));
    if (box) {
        event.preventDefault();
        box.focus();
        box.select();
    }
});
