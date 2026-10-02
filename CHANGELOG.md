# Changelog

All notable changes to `larawellui/larawellui` are listed here. The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and versions follow [Semantic Versioning](https://semver.org/).

Widgets are copied into your app, so a new release doesn't change them until you run `php artisan larawell:add --installed`.

## [Unreleased]

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
