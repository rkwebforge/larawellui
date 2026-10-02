document.addEventListener('click', async (event) => {
    if (!event.target.closest('[data-delete-wallet]')) {
        return;
    }
    const confirmed = await modal.confirm({
        title: 'Delete this wallet?',
        message: 'Its history will be removed for good.',
        confirm: 'Delete',
        danger: true,
    });
    document.getElementById('confirm-result').textContent = confirmed ? 'Deleted.' : '';
});
