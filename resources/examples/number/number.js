// Fills the field the button controls. The input event lets the number field re-format it, like typing would.
document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-fill-max]');
    const field = button && document.getElementById(button.getAttribute('aria-controls'));
    if (field) {
        field.value = button.dataset.fillMax;
        field.dispatchEvent(new Event('input', { bubbles: true }));
    }
});
