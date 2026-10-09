{{-- Type and press Enter or a comma; paste "red, green, blue" to add all three at once. Backspace in the empty box removes the last tag. The tags submit as name[] (here labels[]), so validate them as an array: 'labels' => ['array', 'max:5'], 'labels.*' => ['string', 'max:30']. --}}
<x-widget.tags name="labels" label="Labels" :value="['urgent', 'billing']" class="max-w-md" />
