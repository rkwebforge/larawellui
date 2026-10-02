// Flash a message and it shows as a toast on the next page load.
return back()->with('success', 'Profile updated.'); // or 'error', 'warning', 'info'

// For a title or another type, flash a 'toast' array.
return redirect()->route('orders.show', $order)->with('toast', [
    'type' => 'info',
    'title' => 'Order placed',
    'message' => 'We will email you when it ships.',
]);
