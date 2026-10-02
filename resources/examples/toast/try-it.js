document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-notify]');
    if (!button) {
        return;
    }
    switch (button.dataset.notify) {
        case 'success':
            toast.success('Profile updated.');
            break;
        case 'error':
            toast.error('Something went wrong.');
            break;
        case 'warning':
            toast.warning('Your session is about to expire.');
            break;
        case 'loading': {
            // A loading toast stays until you update it, e.g. when the request finishes.
            const id = toast.loading('Processing payment...');
            setTimeout(() => toast.update(id, 'success', 'Payment confirmed.'), 2000);
            break;
        }
        case 'dismiss':
            toast.dismiss();
    }
});
