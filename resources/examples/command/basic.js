// An item without href is clicked when chosen, by the pointer or Enter: here, it says what it did.
document.addEventListener('click', (event) => {
    const item = event.target.closest('[data-palette-action]');
    if (item) {
        document.getElementById('palette-action').textContent = item.dataset.paletteAction;
    }
});
