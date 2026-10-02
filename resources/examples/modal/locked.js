// A locked modal ignores Esc, the backdrop and data-modal-close; your code decides when it's done.
document.addEventListener('click', (event) => {
    if (event.target.closest('[data-accept-terms]')) {
        modal.close('accept-terms', { force: true });
    }
});
