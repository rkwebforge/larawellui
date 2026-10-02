{{-- Steps are labels, or arrays with a label plus href (links back to done steps) or locked. --}}
<x-widget.stepper.labelled label="Onboarding" :current="3" :steps="[
    ['label' => 'Account', 'href' => '#account'],
    ['label' => 'Verify identity', 'href' => '#verify'],
    'Bank details',
    ['label' => 'Go live', 'locked' => true],
]" />
