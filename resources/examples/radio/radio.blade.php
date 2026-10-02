{{-- Options take the same shapes as the select, plus an optional description. inline lays them out in a row. --}}
<div class="grid gap-8 sm:grid-cols-2">
    <x-widget.radio name="plan" label="Plan" value="pro" required :options="[
        ['id' => 'starter', 'name' => 'Starter', 'description' => 'Up to 3 wallets'],
        ['id' => 'pro', 'name' => 'Pro', 'description' => 'Unlimited wallets and exports'],
        ['id' => 'team', 'name' => 'Team', 'description' => 'Coming soon', 'disabled' => true],
    ]" />
    <x-widget.radio name="frequency" label="Statement" inline :options="['monthly' => 'Monthly', 'quarterly' => 'Quarterly', 'yearly' => 'Yearly']" value="monthly" />
</div>
