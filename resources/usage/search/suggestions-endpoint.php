// The URL in suggest-url answers GET ?q=… with JSON: a list, or a resource collection ({"data": [...]}). Each suggestion
// is a string, or a label with an optional value (what fills the box), meta, href (a page to open) and group. Keep it
// short, and throttle it: it runs as people type.
Route::get('/products/suggest', function (Request $request) {
    $q = $request->validate(['q' => ['required', 'string', 'max:100']])['q'];

    return Product::query()
        ->where('name', 'like', '%'.addcslashes($q, '%_\\').'%')
        ->orderBy('name')
        ->limit(8)
        ->get()
        ->map(fn (Product $product): array => [
            'label' => $product->name,
            'meta' => $product->category->name,
            'href' => route('products.show', $product),
        ]);
})->middleware('throttle:120,1')->name('products.suggest');
