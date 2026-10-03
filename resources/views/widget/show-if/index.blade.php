@props([
    // The name of the field it follows, as on that field: "contact", "addons[]", "address[country]". Looked for in the
    // same form, or the whole page outside one.
    'field',
    // The value, or a list of values, that shows it: "phone", or ['phone', 'sms']. Left out, any value shows it: a
    // ticked checkbox, a chosen option, text typed in.
    'value' => null,
    // Shown to start with. Left out, it follows the field's old input, so after a failed submit what the person chose is
    // still open. Pass it when the field's value comes from elsewhere: :shown="$user->contact === 'phone'".
    'shown' => null,
])

@php
    $expected = $value === null ? null : array_values(array_map('strval', (array) $value));
    // old() takes dot notation: address[country] is address.country, and addons[] is addons.
    $key = rtrim((string) preg_replace('/\[([^\]]*)\]/', '.$1', $field), '.');
    $current = array_values(array_filter(array_map('strval', (array) old($key)), fn (string $chosen): bool => $chosen !== ''));
    $shown ??= $expected === null ? $current !== [] : array_intersect($current, $expected) !== [];
@endphp

{{--
    A fieldset, because a disabled one takes everything inside out of the form: hidden, its fields don't submit, their
    required can't stop the submit, and inert keeps them out of reach of Tab and screen readers. resources/js/widget/show-if
    shows and hides it as the field changes; the server draws where it starts, so there's no flash before the script runs.
--}}
<fieldset
    data-show-if="{{ $field }}"
    @if ($expected !== null) data-show-value="{{ json_encode($expected) }}" @endif
    @unless ($shown) hidden inert disabled @endunless
    {{ $attributes->class(['m-0 min-w-0 border-0 p-0']) }}
>{{ $slot }}</fieldset>
