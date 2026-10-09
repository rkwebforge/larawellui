{{-- range puts two thumbs on one track. They can't cross, and the one moved last stays on top. It submits [from, to] as name[] (here price[]): validate 'price' => ['array', 'size:2'], 'price.*' => ['integer', 'between:0,1000']. --}}
<x-widget.slider name="price" label="Price" range :value="[200, 750]" :min="0" :max="1000" :step="10" prefix="$" info="Per night, before taxes." class="max-w-sm" />
