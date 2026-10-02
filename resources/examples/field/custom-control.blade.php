{{-- Your own control, matched to the inputs. Text-like markup goes in the box; bare drops the box for a control that draws itself. Give it the id the label points at. --}}
<div class="grid gap-6 sm:grid-cols-2">
    <x-widget.field id="price" label="Price" info="Charged monthly.">
        <div class="border-line relative my-3 flex shrink-0 items-center border-e">
            <select name="currency" aria-label="Currency" class="text-foreground h-full cursor-pointer appearance-none bg-transparent ps-5 pe-9 outline-none">
                <option>USD</option>
                <option>EUR</option>
                <option>GBP</option>
            </select>
            <x-widget.icon name="chevron-down" class="text-muted pointer-events-none absolute inset-e-3 size-4" />
        </div>
        <input id="price" type="text" inputmode="decimal" name="price" value="29.00" aria-describedby="price-info" class="w-full min-w-0 bg-transparent ps-4 pe-5 tabular-nums outline-none">
    </x-widget.field>

    <x-widget.field id="volume" label="Volume" bare>
        <input id="volume" type="range" name="volume" min="0" max="100" value="60" class="accent-primary h-12 w-full cursor-pointer">
    </x-widget.field>
</div>
