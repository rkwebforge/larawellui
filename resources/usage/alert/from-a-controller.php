// flash="status" reads the key Laravel's password reset and email verification screens already use.
return back()->with('status', 'We have emailed your password reset link.');

// Some starter kits flash a code instead of a sentence. Put the words in the view:
// @if (session('status') === 'verification-link-sent')
//     <x-widget.alert tone="success">A new verification link is on its way.</x-widget.alert>
// @endif

// For 'success', 'error', 'warning' and 'info', use <x-widget.toast>; the alert leaves those keys alone.
return back()->with('success', 'Profile updated.');
