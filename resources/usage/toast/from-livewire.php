// From a Livewire action, dispatch a toast event: it shows straight away, no page load needed.
$this->dispatch('toast', type: 'success', message: 'Profile updated.');

// A title, or a different auto-close (in ms, or false to keep it until dismissed), go along the same way.
$this->dispatch('toast', type: 'warning', title: 'Almost full', message: 'You have used 90% of your storage.', autoClose: false);

// A session flash still works when the action redirects, wire:navigate included; it shows once, Back and Forward too.
session()->flash('success', 'Order placed.');
$this->redirect(route('orders.index'), navigate: true);
