<?php

declare(strict_types=1);

namespace LarawellUi\Support;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\ComponentAttributeBag;

/**
 * Server-side state of one form widget: its dot-notation key, a valid id, its validation
 * messages and its old input. Every <x-widget.input.*> and the date picker resolve through
 * here, so array names (items[0][date]) and named error bags behave the same everywhere.
 */
final class FormField
{
    /**
     * @param  list<string>  $errors
     */
    private function __construct(
        public readonly ?string $name,
        public readonly string $id,
        public readonly ?string $key,
        public readonly array $errors,
        // The property a wire:model or x-model attribute binds it to, if any.
        public readonly ?string $bound = null,
    ) {}

    /**
     * @param  mixed  $errorBag  the view's shared $errors (absent outside a web request)
     * @param  string|array<int, string>|null  $error  an explicit message from the caller; overrides the bag
     */
    public static function make(
        ?string $name,
        ?string $id,
        mixed $errorBag,
        string|array|null $error = null,
        string $bag = 'default',
        string $idPrefix = 'field',
        ?ComponentAttributeBag $attributes = null,
    ): self {
        // With no name, a Livewire or Alpine binding (wire:model="email") names the field. Its errors are filed under
        // that property, and its id stays the same on every render, which Livewire's morph needs to keep the element
        // (it matches elements by id: a random one makes it swap in a new field, dropping focus mid-typing).
        $bound = $attributes === null ? null : self::boundTo($attributes);
        $key = match (true) {
            $name !== null && $name !== '' => self::key($name),
            $bound !== null => self::key($bound),
            default => null,
        };

        $messages = match (true) {
            $error !== null => Arr::wrap($error),
            $key !== null && $errorBag instanceof ViewErrorBag => self::messagesFor($errorBag->getBag($bag), $key),
            default => [],
        };

        return new self(
            $name,
            app(ElementIds::class)->claim(
                $id ?? ($key !== null ? self::idFrom($key) : $idPrefix.'-'.Str::random(6)),
                explicit: $id !== null,
            ),
            $key,
            array_values(array_filter($messages, static fn (mixed $message): bool => is_string($message) && $message !== '')),
            $bound,
        );
    }

    /**
     * The field's own messages, plus those Laravel files per item for a list of values: a 'tags.*' rule
     * reports a bad second choice under tags.1, which a multiple select named tags must still show. Only
     * numbered children count, so a field named address doesn't take errors meant for address[city].
     *
     * @return list<string>
     */
    private static function messagesFor(MessageBag $bag, string $key): array
    {
        $items = array_filter(
            $bag->getMessages(),
            static fn (string $name): bool => preg_match('/^'.preg_quote($key, '/').'\.\d+$/', $name) === 1,
            ARRAY_FILTER_USE_KEY,
        );

        return array_values(array_unique([...$bag->get($key), ...array_merge(...array_values($items))]));
    }

    /**
     * items[0][date] → items.0.date and tags[] → tags: the key Laravel files errors and old input under.
     */
    public static function key(string $name): string
    {
        return trim((string) preg_replace('/\[([^\]]*)\]/', '.$1', $name), '.');
    }

    /**
     * The id a field named $name gets when it's the first of that name on the page, for links to it
     * (the error summary). A later duplicate gets a -2 suffix, which links can't know about.
     */
    public static function idFor(string $name): string
    {
        return self::idFrom(self::key($name));
    }

    /**
     * The property a wire:model or x-model attribute (any modifiers) binds the field to; null without one.
     */
    public static function boundTo(ComponentAttributeBag $attributes): ?string
    {
        return array_values(self::binding($attributes))[0] ?? null;
    }

    private static function idFrom(string $key): string
    {
        return trim((string) preg_replace('/[^A-Za-z0-9_-]+/', '-', $key), '-');
    }

    public function hasError(): bool
    {
        return $this->errors !== [];
    }

    public function errorId(): string
    {
        return $this->id.'-error';
    }

    public function infoId(): string
    {
        return $this->id.'-info';
    }

    /**
     * Old input after a failed validation, falling back to the widget's value prop, or with none, to the bound Livewire
     * property: a re-render then draws the field as it is, which Livewire morphs onto the page.
     */
    public function old(mixed $default = null): mixed
    {
        if ($default === null) {
            [$found, $live] = $this->fromLivewire();
            $default = $found ? $live : null;
        }

        return $this->key === null ? $default : old($this->key, $default);
    }

    /**
     * The bound property's value while Livewire renders the component that holds it: Livewire shares that component
     * with every view as $__livewire. Livewire isn't a dependency; it's only looked for. [false, null] otherwise.
     * $key reads inside it: a range bound to period reads period.start.
     *
     * @return array{0: bool, 1: mixed}
     */
    public function fromLivewire(?string $key = null): array
    {
        $component = $this->bound === null ? null : view()->shared('__livewire');

        return is_object($component) ? [true, data_get($component, $key === null ? $this->bound : "{$this->bound}.{$key}")] : [false, null];
    }

    /**
     * The binding attribute as written (wire:model.live => period), to put on the inputs that carry the value: a range
     * picker binds period.start and period.end with the same modifiers. Empty without one.
     *
     * @return array<string, string>
     */
    public static function binding(ComponentAttributeBag $attributes): array
    {
        foreach ($attributes->getAttributes() as $attribute => $value) {
            if (is_string($value) && $value !== '' && (str_starts_with($attribute, 'wire:model') || str_starts_with($attribute, 'x-model'))) {
                return [$attribute => $value];
            }
        }

        return [];
    }

    /**
     * Whether a checkbox or switch renders ticked. An unticked box isn't in the request at all, so after a
     * failed submit "no old value" means unticked, but only when that submit was this box's own form. A page
     * with a second form (or a disabled box, which is never sent) would otherwise lose every `checked`.
     *
     * @param  bool  $alwaysSent  it has an unchecked-value, so its form always sends something under its name
     * @param  mixed  $errorBag  the view's shared $errors
     */
    public function checked(mixed $value, bool $default, bool $disabled, bool $alwaysSent, mixed $errorBag, string $bag = 'default'): bool
    {
        // Bound to a Livewire property: that says, true/false, or for a list of boxes, whether it holds this value.
        [$found, $live] = $this->fromLivewire();
        if ($found) {
            return is_array($live) ? in_array(self::text($value), array_map(self::text(...), $live), true) : (bool) $live;
        }
        if ($this->key === null || $disabled || !session()->hasOldInput()) {
            return $default;
        }

        $old = old($this->key);
        if ($old !== null) {
            return in_array(self::text($value), array_map(self::text(...), Arr::wrap($old)), true);
        }
        // Nothing under this name, though this box always sends something: its form wasn't the one submitted.
        if ($alwaysSent) {
            return $default;
        }
        // A form with its own error bag: no errors in that bag means the failed submit was a different form.
        if ($bag !== 'default') {
            return $errorBag instanceof ViewErrorBag && $errorBag->getBag($bag)->isNotEmpty() ? false : $default;
        }

        // One form, or forms sharing the default bag: there's no telling them apart, so trust the old input.
        return false;
    }

    /** Values cast to backed enums (Plan::Pro) compare as their backing value. */
    private static function text(mixed $value): string
    {
        return (string) ($value instanceof \BackedEnum ? $value->value : $value);
    }

    /**
     * What the caller passed, minus `class` (that styles the wrapper) and the aria attributes
     * this widget manages itself. Goes on the element that is actually submitted.
     */
    public function forwarded(ComponentAttributeBag $attributes): ComponentAttributeBag
    {
        return $attributes->except(['class', 'aria-invalid', 'aria-describedby']);
    }

    /**
     * aria-invalid plus one aria-describedby that joins the error, the hint and the caller's own
     * ids. Two separate aria-describedby attributes would make the browser silently drop one.
     */
    public function aria(ComponentAttributeBag $attributes, bool $hasInfo = false): ComponentAttributeBag
    {
        $describedBy = array_filter([
            $this->hasError() ? $this->errorId() : null,
            $hasInfo ? $this->infoId() : null,
            $attributes->get('aria-describedby'),
        ]);

        return new ComponentAttributeBag([
            'aria-invalid' => $this->hasError() ? 'true' : null,
            'aria-describedby' => $describedBy === [] ? null : implode(' ', $describedBy),
        ]);
    }

    /**
     * For a widget whose visible control isn't the submitted input (grouped number, phone): what belongs on the
     * hidden input that carries the value. Which form it's in, and Livewire and Alpine bindings, go with the value.
     */
    public function bindings(ComponentAttributeBag $attributes): ComponentAttributeBag
    {
        return $attributes->filter(static fn (mixed $value, string $key): bool => self::isBinding($key));
    }

    /**
     * The other side of bindings(): everything else the caller passed (required, autofocus, aria-label,
     * placeholder…) goes on the visible control, where the browser validates it and screen readers hear it.
     */
    public function visibleAttributes(ComponentAttributeBag $attributes, bool $hasInfo = false): ComponentAttributeBag
    {
        return $this->controlAttributes($attributes->filter(static fn (mixed $value, string $key): bool => !self::isBinding($key)), $hasInfo);
    }

    private static function isBinding(string $key): bool
    {
        return $key === 'form' || str_starts_with($key, 'wire:model') || str_starts_with($key, 'x-model');
    }

    /**
     * forwarded() and aria() together, for widgets whose visible control is also the submitted one.
     */
    public function controlAttributes(ComponentAttributeBag $attributes, bool $hasInfo = false): ComponentAttributeBag
    {
        return $this->forwarded($attributes)->merge($this->aria($attributes, $hasInfo)->getAttributes());
    }
}
