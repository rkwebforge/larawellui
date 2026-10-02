// Drives <x-widget.select>. Open/close, Esc and click-outside come from the native popover;
// this adds keyboard navigation, type-to-jump, search filtering and positioning under the field.
import { closeIfOutOfView } from '../field';

const VIEWPORT_EDGE = 16;
const GAP = 4;

// Set up once per element. Not a data attribute: Livewire's morph removes attributes the server didn't render, and a
// second set-up would add every listener twice.
const ready = new WeakSet();

function initSelect(root) {
    if (ready.has(root)) {
        return;
    }
    ready.add(root);

    const trigger = root.querySelector('[data-select-trigger]');
    const input = root.querySelector('[data-select-input]');
    const display = root.querySelector('[data-select-display]');
    const meta = root.querySelector('[data-select-meta]');
    const popup = root.querySelector('[data-select-popup]');
    const search = popup.querySelector('[data-select-search]');
    const empty = popup.querySelector('[data-select-empty]');
    // Read each time, not once: a Livewire render or other script can replace the options (a city list that follows
    // the country), and the new ones must be pickable.
    const options = () => [...popup.querySelectorAll('[role="option"]')];
    // multiple: picking toggles an option and the list stays open; each choice is its own hidden name[] input.
    const multiple = root.dataset.multiple === 'true';
    const values = root.querySelector('[data-select-values]');
    // multiple with wire:model or x-model: the hidden native multi-select they're bound to.
    const model = root.querySelector('[data-select-model]');
    const clearButton = root.querySelector('[data-select-clear]');
    // multiple only: list (labels joined), chips (one removable chip each) or count ("3 selected").
    const displayMode = root.dataset.display ?? 'list';
    const chips = root.querySelector('[data-select-chips]');
    const chipTemplate = root.querySelector('[data-select-chip-template]');
    // The field frame's box, so the list lines up with the whole field rather than just the button.
    const anchor = trigger.parentElement;

    let active = -1;
    let typed = '';
    let typedTimer = null;

    const isOpen = () => popup.matches(':popover-open');
    const visible = () => options().filter((option) => !option.hidden);
    // With a search box, focus lives there; otherwise it stays on the trigger.
    const focusOwner = () => search ?? trigger;

    function setActive(index) {
        const list = visible();
        options().forEach((option) => option.removeAttribute('data-active'));
        active = list[index] ? index : -1;

        if (active === -1) {
            focusOwner().removeAttribute('aria-activedescendant');

            return;
        }
        list[active].setAttribute('data-active', '');
        list[active].scrollIntoView({ block: 'nearest' });
        focusOwner().setAttribute('aria-activedescendant', list[active].id);
    }

    const isEnabled = (option) => !option.hasAttribute('aria-disabled');

    // Next enabled option from `from` in `step` direction; stays put when there isn't one.
    function move(step, from = active) {
        const list = visible();
        for (let i = from + step; i >= 0 && i < list.length; i += step) {
            if (isEnabled(list[i])) {
                setActive(i);

                return;
            }
        }
    }

    const chosen = () => options().filter((option) => option.getAttribute('aria-selected') === 'true');

    function drawChips(picked) {
        chips.querySelectorAll('[data-select-chip]').forEach((chip) => chip.remove());
        const placeholder = chips.querySelector('[data-select-chips-placeholder]');
        for (const option of picked) {
            const chip = chipTemplate.content.firstElementChild.cloneNode(true);
            const remove = chip.querySelector('[data-select-chip-remove]');
            chip.querySelector('[data-select-chip-label]').textContent = option.dataset.label;
            remove.dataset.value = option.dataset.value;
            remove.setAttribute('aria-label', `Remove ${option.dataset.label}`);
            remove.disabled = trigger.disabled;
            placeholder.before(chip);
        }
        placeholder.hidden = picked.length > 0;
    }

    // Redraws the trigger from the options' aria-selected: one label, several joined, a count, or chips.
    function refresh() {
        const picked = chosen();
        const text = picked.map((option) => option.dataset.label).join(', ');
        const shown = displayMode === 'count' && picked.length > 1 ? root.dataset.countLabel.replace(':count', String(picked.length)) : text;
        display.textContent = shown || display.dataset.placeholder;
        display.toggleAttribute('data-empty', !text);
        text ? (display.title = text) : display.removeAttribute('title');
        if (chips) {
            drawChips(picked);
        }
        meta.textContent = multiple ? '' : (picked[0]?.dataset.meta ?? '');
        if (clearButton) {
            clearButton.hidden = picked.length === 0;
        }
    }

    // Writes the choice to the hidden input(s) and announces it.
    function commit() {
        const picked = chosen();
        const target = multiple ? (model ?? values) : input;
        if (model) {
            const chosenValues = new Set(picked.map((option) => option.dataset.value));
            [...model.options].forEach((item) => {
                item.selected = chosenValues.has(item.value);
            });
        }
        if (multiple) {
            values.replaceChildren(...picked.map((option) => {
                const hidden = Object.assign(document.createElement('input'), {
                    type: 'hidden',
                    name: values.dataset.name ? `${values.dataset.name}[]` : '',
                    value: option.dataset.value,
                });
                // A select outside its <form> (form="…") keeps submitting with it, as the server-rendered inputs did.
                if (values.dataset.form) {
                    hidden.setAttribute('form', values.dataset.form);
                }

                return hidden;
            }));
        } else {
            input.value = picked[0]?.dataset.value ?? '';
        }
        // Both events: tools like Alpine x-model and Livewire wire:model listen for `input`, plain forms for `change`.
        target.dispatchEvent(new Event('input', { bubbles: true }));
        target.dispatchEvent(new Event('change', { bubbles: true }));
        root.dispatchEvent(new CustomEvent('select-change', {
            bubbles: true,
            detail: multiple
                ? { values: picked.map((option) => option.dataset.value), labels: picked.map((option) => option.dataset.label) }
                : { value: picked[0]?.dataset.value ?? '', label: picked[0]?.dataset.label ?? '' },
        }));
    }

    function choose(option) {
        if (!option || option.hasAttribute('aria-disabled')) {
            return;
        }
        if (multiple) {
            option.setAttribute('aria-selected', String(option.getAttribute('aria-selected') !== 'true'));
            refresh();
            commit();

            return;
        }
        options().forEach((item) => item.setAttribute('aria-selected', String(item === option)));
        refresh();
        commit();
        popup.hidePopover();
        trigger.focus();
    }

    // A chip's own remove button, and Backspace on the closed field for the last chip.
    const unpick = (option) => {
        option?.setAttribute('aria-selected', 'false');
        refresh();
        commit();
    };
    chips?.addEventListener('click', (event) => {
        const remove = event.target.closest('[data-select-chip-remove]');
        if (remove) {
            unpick(options().find((option) => option.dataset.value === remove.dataset.value));
            trigger.focus();
        }
    });
    trigger.addEventListener('keydown', (event) => {
        if (chips && event.key === 'Backspace' && !isOpen()) {
            unpick(chosen().at(-1));
        }
    });

    clearButton?.addEventListener('click', () => {
        options().forEach((option) => option.setAttribute('aria-selected', 'false'));
        refresh();
        commit();
        trigger.focus();
    });

    function filter(query) {
        const needle = query.trim().toLowerCase();
        options().forEach((option) => {
            option.hidden = needle !== '' && !option.dataset.label.toLowerCase().includes(needle);
        });
        empty.hidden = visible().length > 0;
        setActive(-1);
        move(1, -1);
    }

    function position() {
        if (closeIfOutOfView(anchor, popup)) {
            return;
        }
        const box = anchor.getBoundingClientRect();
        popup.style.width = `${box.width}px`;

        const height = popup.offsetHeight;
        const below = box.bottom + GAP;
        const above = box.top - GAP - height;
        const fitsBelow = below + height <= window.innerHeight - VIEWPORT_EDGE;

        popup.style.top = `${fitsBelow || above < VIEWPORT_EDGE ? below : above}px`;
        popup.style.left = `${box.left}px`;
    }

    // Native <select> behaviour: typing letters jumps to the first matching option.
    function typeahead(character) {
        typed += character.toLowerCase();
        clearTimeout(typedTimer);
        typedTimer = setTimeout(() => { typed = ''; }, 500);

        const list = visible();
        const match = list.findIndex((option) => isEnabled(option) && option.dataset.label.toLowerCase().startsWith(typed));
        if (match !== -1) {
            setActive(match);
        }
    }

    function handleListKeys(event) {
        switch (event.key) {
            case 'ArrowDown':
                event.preventDefault();
                isOpen() ? move(1) : popup.showPopover();
                break;
            case 'ArrowUp':
                event.preventDefault();
                isOpen() ? move(-1) : popup.showPopover();
                break;
            case 'Home':
            case 'End':
                if (isOpen()) {
                    event.preventDefault();
                    // Start just outside the list so the first/last enabled option wins.
                    event.key === 'Home' ? move(1, -1) : move(-1, visible().length);
                }
                break;
            case 'Enter':
                // Stops the button's native popover toggle so Enter picks instead. While the list is open, Enter
                // never falls through, even with nothing highlighted: in the search box it would submit the form.
                if (isOpen()) {
                    event.preventDefault();
                    if (active !== -1) {
                        choose(visible()[active]);
                    }
                }
                break;
            case 'Tab':
                if (isOpen()) {
                    popup.hidePopover();
                }
                break;
            default:
                return false;
        }

        return true;
    }

    trigger.addEventListener('keydown', (event) => {
        if (handleListKeys(event)) {
            return;
        }
        // Space in the middle of type-ahead ("new z…") is part of the search, as in a native select; otherwise it picks.
        if (event.key === ' ' && isOpen() && typed !== '') {
            event.preventDefault();
            typeahead(' ');
        } else if (event.key === ' ' && isOpen() && active !== -1) {
            event.preventDefault();
            choose(visible()[active]);
        } else if (isOpen() && event.key.length === 1 && event.key !== ' ' && !event.ctrlKey && !event.metaKey && !event.altKey) {
            typeahead(event.key);
        }
    });

    search?.addEventListener('keydown', handleListKeys);
    search?.addEventListener('input', () => filter(search.value));

    popup.addEventListener('click', (event) => {
        const option = event.target.closest('[role="option"]');
        if (option) {
            choose(option);
        }
    });
    popup.addEventListener('mousemove', (event) => {
        const option = event.target.closest('[role="option"]:not([aria-disabled])');
        if (option && !option.hasAttribute('data-active')) {
            setActive(visible().indexOf(option));
        }
    });
    // Keep focus on the trigger/search while clicking an option.
    popup.addEventListener('mousedown', (event) => {
        if (event.target.closest('[role="option"]')) {
            event.preventDefault();
        }
    });

    popup.addEventListener('beforetoggle', (event) => {
        if (event.newState === 'open') {
            // Hidden until positioned, otherwise it flashes at the popover default (screen centre).
            popup.style.visibility = 'hidden';
        }
    });

    popup.addEventListener('toggle', (event) => {
        const open = event.newState === 'open';
        trigger.setAttribute('aria-expanded', String(open));

        if (!open) {
            window.removeEventListener('scroll', position, true);
            window.removeEventListener('resize', position);
            setActive(-1);
            if (search) {
                search.value = '';
                filter('');
                setActive(-1);
            }

            return;
        }

        position();
        popup.style.visibility = '';
        // Start on the selected option, like a native select.
        setActive(visible().findIndex((option) => option.getAttribute('aria-selected') === 'true'));
        search?.focus();
        // Capture phase so scrolling any ancestor also repositions it.
        window.addEventListener('scroll', position, true);
        window.addEventListener('resize', position);
    });
}

// For a select that stays put while the markup around it is swapped (a table's filters toolbar): takes the fresh
// copy's option details, each option's meta (e.g. a count) and whether it's disabled, and keeps what's chosen.
export function refreshOptions(select, fresh) {
    const next = new Map([...fresh.querySelectorAll('[role="option"][data-value]')].map((option) => [option.dataset.value, option]));
    select.querySelectorAll('[role="option"][data-value]').forEach((option) => {
        const source = next.get(option.dataset.value);
        if (!source) {
            return;
        }
        option.dataset.meta = source.dataset.meta ?? '';
        const meta = option.querySelector('[data-select-option-meta]');
        if (meta) {
            meta.textContent = source.dataset.meta ?? '';
        }
        if (source.hasAttribute('aria-disabled')) {
            option.setAttribute('aria-disabled', 'true');
        } else {
            option.removeAttribute('aria-disabled');
        }
    });
    const shown = select.querySelector('[data-select-meta]');
    if (shown && select.dataset.multiple !== 'true') {
        shown.textContent = select.querySelector('[role="option"][aria-selected="true"]')?.dataset.meta ?? '';
    }
}

export function initSelects(scope = document) {
    scope.querySelectorAll('[data-select]').forEach(initSelect);
}

initSelects();

// Selects added to the page later (a Livewire render or wire:navigate, fetched HTML) set themselves up.
new MutationObserver((records) => {
    for (const node of records.flatMap((record) => [...record.addedNodes])) {
        if (node instanceof Element) {
            (node.matches('[data-select]') ? [node] : node.querySelectorAll('[data-select]')).forEach(initSelect);
        }
    }
}).observe(document.documentElement, { childList: true, subtree: true });
