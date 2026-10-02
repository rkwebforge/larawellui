{{-- A step can need attention (error, and an href lets the user go back and fix it), be optional, or be locked until earlier steps are done. On phones only the current step's name shows, so longer flows still fit. --}}
<x-widget.stepper.labelled label="Onboarding" :current="3" :steps="[
    ['label' => 'Account', 'href' => '#account'],
    ['label' => 'Verify identity', 'error' => true, 'href' => '#verify'],
    'Bank details',
    ['label' => 'Invite team', 'optional' => true],
    ['label' => 'Go live', 'locked' => true],
]" />
