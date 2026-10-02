{{-- variant="pills": rounded buttons, the open one filled. Good for filters above a list. value opens one other than the first. --}}
<x-widget.tabs id="order-status" label="Orders" variant="pills" value="open" :tabs="['all' => 'All', 'open' => 'Open', 'shipped' => 'Shipped', 'returned' => 'Returned']">
    <x-slot:all>Every order.</x-slot:all>
    <x-slot:open>Orders waiting to ship.</x-slot:open>
    <x-slot:shipped>Orders on their way.</x-slot:shipped>
    <x-slot:returned>Orders sent back.</x-slot:returned>
</x-widget.tabs>
