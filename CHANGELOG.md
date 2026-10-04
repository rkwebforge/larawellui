# Changelog

All notable changes to `larawellui/larawellui` are listed here, by widget, so you can see what an update brings to the ones you use. The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and versions follow [Semantic Versioning](https://semver.org/).

## Updating

Widgets are copied into your app, so a new release changes nothing until you run `php artisan larawell:add --installed`. That updates the files you haven't edited and lists the ones you have; `php artisan larawell:diff` shows what those would miss.

What you build on is only ever added to, never renamed or removed: component names, props and the values they take, `data-*` hooks, JS exports, the `larawell:*` commands and their flags, and the config keys. A release can still get stricter about input that never worked, such as a mistyped value that used to be ignored and now throws. Those changes are listed under **Changed**, with the widgets they affect.

## [Unreleased]

## [0.2.2] - 2026-10-04

### Added

- **All widgets** (`base.css`): a `data-theme-changing` hook for switching theme while the page is open. Set it on `<html>` for the switch and the widgets' colour transitions are held back, so fields, buttons and table rows change at once instead of each fading at its own speed. The README's Theming section shows the toggle.

### Changed

- **button** (`<x-widget.button.back>`): the arrow sits closer to its label (`gap-1.5`, as on the button, instead of `gap-5`), so the two read as one link.

### Fixed

- **table**: changing page, sort or filter in place no longer makes the browser report a Content Security Policy violation for each inline `<style>` on the page it fetches, such as the one Laravel's `@fonts` adds. Those carry the fetched response's nonce, not the current page's; the table now drops them before reading the page.
- **PHP helpers and validation rules** (copied to `App\View\Widget` and `App\Rules`): written in Laravel Pint's default style. Before, running Pint in your app reformatted seven of them, which marked them as edited, so `larawell:add --installed` skipped their updates.

## [0.2.1] - 2026-10-04

### Added

- **field**: a `data-field-info` hook on the hint, which the field's script uses to announce the hint again once an error clears.

### Fixed

- **All form widgets**: a field showing an error is described by the error alone. Before, screen readers also read the hint the error hides, often two sentences saying nearly the same thing, like the birthday picker's "You must be 18 or older." after "You must be at least 18 years old." The hint is announced again once the error clears.
- **table**: the sortable example's demo data no longer logs a PHP deprecation ("Implicit conversion from float … to int") when it builds its amounts.

## [0.2.0] - 2026-10-03

### Added

- **show-if**: a new widget that shows part of a form only while another field has a given value, such as a phone number when Phone is chosen. Hidden, its fields don't submit and their required can't block the form; it starts in the right state after a failed submit, nests, and works inside Livewire.
- **breadcrumbs**: a new widget showing where a page sits, as a trail of links down to the current page (`aria-current="page"`). On phones, one link back up instead. Chevron or slash separators, an icon-only Home that keeps its name, and long labels cut short with the full text on hover.
- **search**: suggestions as you type, like a store's search, with `suggest-url`: your endpoint answers `GET ?q=…` with JSON. Suggestions can carry details, open a page directly (`href`) or sit under group headings; the typed text shows in bold. Keyboard and screen-reader support follow the ARIA combobox pattern, requests wait for a pause in typing and drop stale answers, and a failed one is announced. `suggest-min` and `messages` tune it.
- **select**: `search-url` searches your app as you type, for lists too long to send to the page (customers, products). Single or multiple: choices stay picked across searches, the chosen option(s) you pass show before any search, and other options you pass show as a starter list until you type. Searching and failures are shown and announced; `search-min-length`, `searching` and `search-failed` tune it. A Livewire `wire:model` multiple select takes values a search brought.
- **All widgets**: a dark theme in `theme.css`, at WCAG AA. Put `class="dark"` or `data-theme="dark"` on `<html>`, or on any element for just that part of the page.
- **Theme**: `primary-fill`, `error-fill` and `success-fill`, for solid backgrounds that carry white text. `primary`, `error` and `success` are now only for text, borders, focus rings and tints, so dark mode can make those lighter without failing contrast. In light mode each fill follows its base colour unless you set it, and `primary-hover` is now a darker mix of `primary-fill` in both modes, so a theme that changed only `primary` looks as it did, hover included. In dark mode the fills are a deeper shade of their own; if you change the brand colour, set the dark pair too.
- **icon**: 24 icons: arrow-down, arrow-up, bell, bookmark, circle-help, circle-x, credit-card, download, external-link, filter, globe, heart, home, link, mail, map-pin, menu, phone, send, settings, share, star, tag and users.
- **All widgets**: a manifest can name, in `examples-use`, other widgets its examples use without needing them itself. The page, `/r/{name}.json` (`examples_use`, `examples_install`), `larawell:list --json` and MCP list them with the command that adds them.
- **All widgets**: every prop has a description on its component's page, in `/r/*.json` and through MCP. Props that take one of a set of values list them all, and the icon's `name` lists every icon.

### Changed

- **button, checkbox, accordion, date pickers, modal, pagination, progress, stepper, tabs, time-picker**: solid backgrounds under white text use the new fill colours, and focus rings leave a surface-coloured gap instead of a white one.
- **All widgets**: a value a prop doesn't take, like `variant="primay"` or `size="xl"`, now throws and names the values it does take. Before, the widget quietly used its default. If a value comes from your data (a status, a setting), map it to the widget's values with a default first; see "Values from your data" in the README. This covers accordion, alert, button, captcha, clock, dropdown, file-upload, modal, otp, pagination, price-roll, progress, search, select, stepper, switch, table, tabs, time-picker, toast and tooltip.
- **button**: `type` takes only button, submit or reset.
- **dropdown**: an item's `method` takes only GET, POST, PUT, PATCH or DELETE, in any case.
- **file-upload**: `uploaded` needs `upload-url`. Without it, a picked file was submitted under the same name as the stored ids and replaced them.
- **modal**: a drawer with `size="full"`, and `mobile="sheet"` on a drawer or a full-screen dialog, now throw. They used to be ignored.
- **table**: a row with both `href` and a details slot throws, because a click can only do one of the two. `bulk-method` takes only GET, POST, PUT, PATCH or DELETE.

### Fixed

- **field**: the required check for the select, date pickers and time picker skips fields inside a disabled fieldset, as the browser's own checks do. Before, a hidden required one could stop the form.
- **time-picker**: the list and each column now have one Tab stop, the chosen time or else the first that can be picked, which follows focus as the arrow keys move (a roving tabindex). Before, no option could be reached with Tab, and a scrolling list had no keyboard way in.
- **table**: an expandable row opens from a real Details button in its chevron cell, which carries `aria-expanded`. ARIA doesn't allow that on a table row, so screen readers could miss whether it was open. A click anywhere on the row still opens it.
- **tooltip**: around an icon with no text, the focusable wrapper is now an image named by the tooltip (`role="img"`). Before, it had a name but no role, which isn't allowed.
- **file-upload**: the button and image uploads no longer give their input two labels, which some screen readers read only half of. The input is named by the field label and the button's text, e.g. "Profile photo, Choose image".
- **progress, search**: the live-progress and search-form examples use `primary-fill` behind their white text, so they pass contrast in dark mode.
- **clock**: the countdown no longer gets an empty `aria-label` when its label is "".
- **icon, clock, pagination**: the icon's `name`, the clock's `hour12`, and the pagination components' `paginator` and `segmented` were missing from the docs, `/r/*.json` and MCP.
- **stepper**: the bars stepper takes the same step arrays as the other steppers (`['label' => …]`) instead of failing on them.

## [0.1.0] - 2026-10-02

### Added

- 34 widgets: accordion, alert, button, captcha, checkbox, clock, date-range-picker, datepicker, dropdown, field, file-upload, icon, modal, number, otp, pagination, password, phone, price-roll, progress, radio, search, select, stepper, switch, table, tabs, text-input, textarea, time-picker, toast, tooltip, tooltip-cursor and verification-code.
- `larawell:add`, which copies widgets and everything they need into your app, with `--dry-run`, `--installed` and `--force`.
- `larawell:list`, with `--json` for tools and AI agents.
- `larawell:diff`, which shows how your edited copies differ from the package.
- `larawell:mcp`, an MCP server for AI agents: browse the catalogue, see what's installed and edited, and install with a dry run first.
- `larawellui.lock`, so updates replace only the files you haven't edited.
- Livewire 3 and 4 support, with `wire:model` on every form control.

[Unreleased]: https://github.com/rkwebforge/larawellui/compare/v0.2.2...HEAD
[0.2.2]: https://github.com/rkwebforge/larawellui/compare/v0.2.1...v0.2.2
[0.2.1]: https://github.com/rkwebforge/larawellui/compare/v0.2.0...v0.2.1
[0.2.0]: https://github.com/rkwebforge/larawellui/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/rkwebforge/larawellui/releases/tag/v0.1.0
