// window.toast is available once the toast script has loaded.
toast.success('Profile updated.');
toast.error('Something went wrong.');
toast.warning('Your session is about to expire.');
toast.info('New version available.');

// A loading toast stays until you update or dismiss it.
const id = toast.loading('Processing payment...');
toast.update(id, 'success', 'Payment confirmed.');

toast.dismiss(id); // one toast
toast.dismiss();   // all of them
