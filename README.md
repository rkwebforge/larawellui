# LarawellUi

`larawellui/larawellui`. The catalogue site lives in the host app of this repo: live previews, props, source, and `/llms.txt` plus `/r/{name}.json` for AI agents.

Blade + Tailwind CSS v4 widgets for Laravel that you copy into your app, then own. No Livewire or Alpine needed: server-rendered Blade, plus a small vanilla JS file per widget that hooks onto `data-*` attributes. They work inside Livewire 3 and 4 components too (see below).

## Requirements

- PHP 8.3+, Laravel 12 or 13
- Tailwind CSS 4.1+ and Vite (the default Laravel setup), and pages rendered with Blade
- `datepicker`, `date-range-picker`, `time-picker` and `price-roll` need the PHP `intl` extension
- Browsers: Chrome/Edge 117+, Firefox 129+, Safari 17.5+ (all 2024). Chrome/Edge 114–116, Firefox 128 and Safari 17–17.4 work with some animations skipped. Older browsers can't open the popover-based widgets (select, date pickers, the time picker's list and columns, phone country list, dropdown, tooltips).
- On iOS/iPadOS before 18.3, tapping outside an open popover doesn't close it ([WebKit bug 267688](https://webkit.org/b/267688)).

Works under a strict Content Security Policy (`default-src 'self'`, no `'unsafe-inline'`): no widget renders inline scripts, event handlers or `style` attributes. The one opt-in exception is `remember` on the accordion menu: its small inline script carries your nonce if you set one with `Vite::useCspNonce()`, and where a CSP blocks it the menu still works, opening at the current page without remembering. Sizes the server works out are classes from the `@source inline()` ranges at the end of `base.css` (about 2 KB gzipped). Examples that call a widget's JS come with a `{slug}.js` for your own script. The captcha's provider options need that provider's domain in `script-src` and `frame-src`.

Not a fit for Tailwind v3 or Bootstrap projects, or for Inertia pages written in React or Vue. Components added to the page later (a Livewire render, `wire:navigate`, fetched fragments) set themselves up. The table, every input, the date pickers and the pagination work inside Livewire components. The table's page, sort and rows-per-page links update the component in place (see the table's Usage). Inputs bind with `wire:model` without a name, keep focus while you type, show the property's value after every render (a value set in PHP included) and read `$errors` under the property; the select takes options that change, and the captcha keeps its image. The file upload sends each file to Livewire's temporary uploads (`WithFileUploads`) as it's picked or dropped, keeps the property equal to its list as files are removed, and keeps its list and preview through renders; tested in a browser with Livewire 3.8 and 4.4. The accordion keeps panels open or shut as the person left them through a render, while what's inside updates; its `open` only sets how a panel starts (same browser test). Alerts update in place; a dismissed one stays hidden until its message changes, a flash set in an action is read out, and the error summary takes focus after a failed `wire:submit` (also browser-tested). A button submitting a `wire:submit` form shows its loading state while Livewire holds it and gets focus back after; `wire:loading.attr="aria-busy"` gives a `wire:click` button the same look (browser-tested). Dropdown items take `wire:click`, `confirm` and disabled items included, and an open menu stays open and in place through a render (browser-tested). The clocks keep ticking through renders, world clocks keep the visitor's offsets, and a running stopwatch or timer keeps running; its props are read once (browser-tested). An open modal stays open through renders, a component opens and closes one with `$this->dispatch('modal-open', id: '…')` and `'modal-close'`, and `reset-on-close` empties bound properties too (browser-tested). A component shows a toast with `$this->dispatch('toast', type: 'success', message: '…')`, and toasts keep working across `wire:navigate`, a flash before it included, shown once (browser-tested). Progress bars and steppers follow their properties through renders, `wire:poll` included; a bar driven by `progress.set()` goes in a `wire:ignore` (browser-tested). A price roll rolls to the value each render brings (browser-tested). Each widget's page shows it in a Livewire component under Usage.

## Install

```bash
composer require --dev larawellui/larawellui
php artisan larawell:add datepicker        # adds datepicker plus field and icon, which it needs
npm run build
```

`larawell:add` copies:

| What | Where |
|---|---|
| Blade components | `resources/views/components/widget/{widget}/` (used as `<x-widget.*>`) |
| JS | `resources/js/widget/{widget}/`, imported from `resources/js/app.js` |
| Theme tokens and base CSS | `resources/css/widget/{theme,base}.css`, imported from `resources/css/app.css` |
| PHP helpers (`FormField`, `ElementIds`, and `Countries` for the phone…) | `App\View\Widget` |
| Validation rules (the date pickers' `NotAfterToday` and `MinimumAge`, the captcha's `Captcha`) | `App\Rules` |

Before writing anything it checks `package.json`: it stops if Tailwind CSS is older than 4.1 (the installed version in `node_modules` if there is one, otherwise whether the declared range can reach 4.1), and warns if Tailwind or Vite isn't listed.

Run it again at any time, for example after `composer update`; `--installed` updates every widget already in the app. Files you haven't edited get the new version, files you have edited are skipped and reported, and `--force` overwrites those too.

It tells the two apart with `larawellui.lock` in your app's root, a hash of each file as it was last installed. Commit it, like `composer.lock`. Files installed before the lock existed can't be told apart, so they are skipped and reported as well; if you haven't edited them, run once with `--force` and from then on updates apply by themselves.

```bash
php artisan larawell:list            # what's available
php artisan larawell:add             # pick from a list
php artisan larawell:list --json     # components, requirements and usage examples, for tools and AI agents
php artisan larawell:add --all
php artisan larawell:add select --dry-run
php artisan larawell:add --installed            # update every widget you have
php artisan larawell:diff                       # diff every file a re-run would skip
php artisan larawell:diff select/index.blade.php # or one file
```

`larawell:diff` compares your copy with this version of the package. To take the package version of one file, delete it and run `larawell:add --installed`.

## AI agents (MCP)

`php artisan larawell:mcp` is a [Model Context Protocol](https://modelcontextprotocol.io) server for the app it runs in, over stdio. No extra package: it ships with this one. Its tools:

| Tool | What it does |
|---|---|
| `list_components` | The catalogue, with whether each is installed; `query` narrows it |
| `get_component` | One component's tags, props, slots, usage (Livewire included) and examples |
| `project_status` | What's installed, which installed files are out of date or edited (from `larawellui.lock`), and the Tailwind/Vite check |
| `add_components` | A dry run by default: lists the files it would write. Writes only with `confirm: true`, and never over edited files unless `force: true` |

Add it to your agent. Claude Code, from the app's root:

```bash
claude mcp add larawellui -- php artisan larawell:mcp
```

Other clients:

**Claude Desktop**: claude_desktop_config.json (Settings > Developer > Edit Config)

```json
{
    "mcpServers": {
        "larawellui": {
            "command": "php",
            "args": [
                "/path/to/your-app/artisan",
                "larawell:mcp"
            ]
        }
    }
}
```

**Cursor**: .cursor/mcp.json

```json
{
    "mcpServers": {
        "larawellui": {
            "type": "stdio",
            "command": "php",
            "args": [
                "${workspaceFolder}/artisan",
                "larawell:mcp"
            ]
        }
    }
}
```

**VS Code (Copilot)**: .vscode/mcp.json

```json
{
    "servers": {
        "larawellui": {
            "type": "stdio",
            "command": "php",
            "args": [
                "artisan",
                "larawell:mcp"
            ],
            "cwd": "${workspaceFolder}"
        }
    }
}
```

**OpenAI Codex CLI**: Terminal

```bash
codex mcp add larawellui -- php /path/to/your-app/artisan larawell:mcp
```

**Gemini CLI**: Terminal, from your app's root

```bash
gemini mcp add larawellui php /path/to/your-app/artisan larawell:mcp
```

**Windsurf**: mcp_config.json (MCP settings > View raw config)

```json
{
    "mcpServers": {
        "larawellui": {
            "command": "php",
            "args": [
                "/path/to/your-app/artisan",
                "larawell:mcp"
            ]
        }
    }
}
```

**Zed**: settings.json

```json
{
    "context_servers": {
        "larawellui": {
            "command": "php",
            "args": [
                "/path/to/your-app/artisan",
                "larawell:mcp"
            ],
            "env": {}
        }
    }
}
```

**JetBrains AI Assistant**: Settings > Tools > AI Assistant > Model Context Protocol > Add, STDIO; Working directory: your app

```json
{
    "mcpServers": {
        "larawellui": {
            "command": "php",
            "args": [
                "artisan",
                "larawell:mcp"
            ]
        }
    }
}
```

**JetBrains Junie**: .junie/mcp/mcp.json

```json
{
    "mcpServers": {
        "larawellui": {
            "command": "php",
            "args": [
                "/path/to/your-app/artisan",
                "larawell:mcp"
            ]
        }
    }
}
```

Any other client: the command `php`, with the arguments `/path/to/your-app/artisan larawell:mcp`. Where a client may not start the server in your app's folder, the full path to `artisan` is what makes it work. If a desktop app can't find `php`, give it the full path too (`which php`).


## Configuration

To install into other namespaces or paths, publish the config:

```bash
php artisan vendor:publish --tag=larawellui-config
```

Both namespaces must sit under a PSR-4 root in your `composer.json`. The installer derives the directory from it.

## Theming

Components only use the token names in `resources/css/widget/theme.css` (`primary`, `field`, `line`, `error`, …). To re-theme, edit the values there.

## Working on the package

- The source runs as-is. Views live in `resources/views/widget/{widget}`, JS in `resources/js/{widget}`, CSS in `resources/css`, and the helpers and rules are real classes in `src/Support` and `src/Rules`. On install, `LarawellUi\Support` and `LarawellUi\Rules` are rewritten to the app's namespaces.
- `registry/{widget}.json` holds the metadata: an optional `title` (when the name doesn't read right as a heading, like `otp`) and `group` (the catalogue heading it's listed under, like `Forms`), `requires`, `support`, `rules`, `composer` and `php-extensions`, plus `examples`, the display order of the files in `resources/examples/{widget}/`. A widget's files are whatever sits in its directories.
- Each example is a Blade file. A leading `{{-- … --}}` comment is its description, and the rest is the code. The site renders it as a live preview and shows the code, and `larawell:list --json` and `/r/{name}.json` hand it to agents. Examples may only use their own widget and the widgets it requires, so copied code always works.
- An example that calls a widget's JS API keeps that call in `{slug}.js` beside it: markup with `data-*` hooks, and one `document.addEventListener` in the script, never `onclick=""` or an inline `<script>`. The site bundles these and shows them under the Blade. No example or widget may render `style=""`: a server-side size becomes a class, added to the `@source inline()` ranges in `base.css` if it's new. The test suite renders every example and fails on either.
- Props are read from each component's `@props` block, one prop per line.
- Every form control (the text input, password, select, the date pickers, the file upload…) sits in `<x-widget.field>` and requires `field`. Its script imports the shared helpers from `'../field'` (`on` for delegated events, `replaceValue`, `typingIn`, `onLivewireMorph`) rather than keeping a copy, and its own Livewire refresh goes through `onLivewireMorph`.
- The host app develops against the source directly. It registers `resources/views` as an anonymous component path (in `AppServiceProvider`) and imports the JS and CSS from `packages/larawellui/resources`. Edit a widget, refresh the page, done.
- The host app's test suite checks that every manifest declares everything its widget renders or imports, that every example renders, and that installing into a fresh project produces working, correctly namespaced files.
