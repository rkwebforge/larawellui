{{-- Options can be a plain list, a key => label map, or rows with id, name and extra meta, which shows beside each option in the list and beside the choice. Long lists get a search box with searchable. --}}
<div class="grid gap-6 sm:grid-cols-2">
    <x-widget.select name="network" label="Network" placeholder="Choose a network" value="trc20" :options="[
        ['id' => 'trc20', 'name' => 'TRC20 (Tron)', 'formattedBalance' => '1,250.00 USDT'],
        ['id' => 'erc20', 'name' => 'ERC20 (Ethereum)', 'formattedBalance' => '310.45 USDT'],
        ['id' => 'bep20', 'name' => 'BEP20 (BNB Chain)', 'formattedBalance' => '0.00 USDT', 'disabled' => true],
    ]" />
    <x-widget.select name="country" label="Country" placeholder="Select a country" searchable search-placeholder="Search countries" :options="[
        'MY' => 'Malaysia', 'SG' => 'Singapore', 'ID' => 'Indonesia', 'TH' => 'Thailand', 'VN' => 'Vietnam',
        'PH' => 'Philippines', 'IN' => 'India', 'JP' => 'Japan', 'KR' => 'South Korea', 'AU' => 'Australia',
        'NZ' => 'New Zealand', 'GB' => 'United Kingdom', 'US' => 'United States', 'AE' => 'United Arab Emirates',
    ]" />
</div>
