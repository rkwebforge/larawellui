{{-- Arrow-shaped segments in a row, like a checkout breadcrumb. Completed steps can link back; on phones the other steps shrink to their number. --}}
<x-widget.stepper.chevrons label="Checkout" :current="3" :steps="[
    ['label' => 'Cart', 'href' => '#cart'],
    ['label' => 'Shipping', 'href' => '#shipping'],
    'Payment',
    'Review',
]" />
