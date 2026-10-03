// Hidden fields don't submit, so validate them only when they apply. exclude_unless also drops them from the validated data.
$request->validate([
    'contact' => ['required', 'in:email,phone'],
    'phone' => ['exclude_unless:contact,phone', 'required', 'string'],
]);
