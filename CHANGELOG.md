# Changelog

All notable changes to `larawellui/larawellui` are listed here, by widget, so you can see what an update brings to the ones you use. The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and versions follow [Semantic Versioning](https://semver.org/).

## Updating

Widgets are copied into your app, so a new release changes nothing until you run `php artisan larawell:add --installed`. That updates the files you haven't edited and lists the ones you have; `php artisan larawell:diff` shows what those would miss.

What you build on is only ever added to, never renamed or removed: component names, props and the values they take, `data-*` hooks, JS exports, the `larawell:*` commands and their flags, and the config keys. A release can still get stricter about input that never worked, such as a mistyped value that used to be ignored and now throws. Those changes are listed under **Changed**, with the widgets they affect.

## [Unreleased]

### Added

- **All widgets**: a dark theme in `theme.css`, at WCAG AA. Put `class="dark"` or `data-theme="dark"` on `<html>`, or on any element for just that part of the page.
- **Theme**: `primary-fill`, `error-fill` and `success-fill`, for solid backgrounds that carry white text. `primary`, `error` and `success` are now only for text, borders, focus rings and tints, so dark mode can make those lighter without failing contrast. In light mode each fill follows its base colour unless you set it, so a theme that changed only `primary` looks as it did. In dark mode the fills are a deeper shade of their own; if you change the brand colour, set the dark pair too.
- **icon**: 24 icons: arrow-down, arrow-up, bell, bookmark, circle-help, circle-x, credit-card, download, external-link, filter, globe, heart, home, link, mail, map-pin, menu, phone, send, settings, share, star, tag and users.
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

[Unreleased]: https://github.com/rkwebforge/larawellui/compare/v0.1.0...HEAD
[0.1.0]: https://github.com/rkwebforge/larawellui/releases/tag/v0.1.0
