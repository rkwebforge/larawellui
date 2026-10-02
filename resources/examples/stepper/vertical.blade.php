{{-- orientation="vertical" stacks the steps with a description under each: onboarding checklists, order tracking. It fits phones as it is. --}}
<x-widget.stepper.labelled class="max-w-sm" orientation="vertical" label="Order status" :current="3" :steps="[
    ['label' => 'Order placed', 'description' => 'We have your order and payment.', 'href' => '#order-placed'],
    ['label' => 'Packed', 'description' => 'Your items are boxed and labelled.'],
    ['label' => 'Shipped', 'description' => 'On its way with the courier. Tracking arrives by email.'],
    ['label' => 'Delivered', 'description' => 'Usually 2 to 4 working days after shipping.'],
]" />
