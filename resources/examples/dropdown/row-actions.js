// The menu closes itself after a choice; the copy is yours.
document.addEventListener('click', (event) => {
    const item = event.target.closest('[data-clipboard]');
    if (item) {
        navigator.clipboard?.writeText(item.dataset.clipboard);
    }
});
