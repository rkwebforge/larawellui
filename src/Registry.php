<?php

declare(strict_types=1);

namespace Bladewell;

use Illuminate\Support\Str;
use InvalidArgumentException;
use JsonException;
use LogicException;

/**
 * The widgets this package can install: registry/*.json for metadata, resources/ and src/ for the source.
 */
final class Registry
{
    /** @var array<string, Widget>|null */
    private ?array $widgets = null;

    public function __construct(private readonly string $root) {}

    public function path(string $path = ''): string
    {
        return rtrim($this->root.'/'.ltrim($path, '/'), '/');
    }

    /**
     * @return array<string, Widget> keyed and sorted by name
     */
    public function all(): array
    {
        if ($this->widgets !== null) {
            return $this->widgets;
        }

        $widgets = [];
        foreach (glob($this->path('registry/*.json')) ?: [] as $file) {
            $name = basename($file, '.json');
            try {
                $data = json_decode((string) file_get_contents($file), true, flags: JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                throw new InvalidArgumentException("registry/{$name}.json is not valid JSON: {$e->getMessage()}", previous: $e);
            }
            $widgets[$name] = Widget::fromManifest($name, is_array($data) ? $data : []);
        }
        ksort($widgets);

        return $this->widgets = $widgets;
    }

    public function get(string $name): Widget
    {
        return $this->all()[$name] ?? throw new InvalidArgumentException(
            "Unknown widget [{$name}]. Available: ".implode(', ', array_keys($this->all())).'.',
        );
    }

    /**
     * The named widgets plus everything they require, each once, dependencies first.
     *
     * @param  list<string>  $names
     * @return list<Widget>
     */
    public function resolve(array $names): array
    {
        $ordered = [];
        foreach ($names as $name) {
            $this->visit($name, [], $ordered);
        }

        return array_values($ordered);
    }

    /**
     * Where a widget's source of one kind lives. Views sit under views/widget so that registering
     * resources/views as an anonymous component path resolves <x-widget.*> straight from the package.
     *
     * @param  'views'|'js'  $kind
     */
    public function dir(Widget $widget, string $kind): string
    {
        return $this->path($kind === 'views' ? "resources/views/widget/{$widget->name}" : "resources/js/{$widget->name}");
    }

    /**
     * A widget's source files of one kind, relative to dir().
     *
     * @param  'views'|'js'  $kind
     * @return list<string>
     */
    public function files(Widget $widget, string $kind): array
    {
        $dir = $this->dir($widget, $kind);
        if (!is_dir($dir)) {
            return [];
        }

        $files = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            if ($file instanceof \SplFileInfo && $file->isFile()) {
                $files[] = substr($file->getPathname(), strlen($dir) + 1);
            }
        }
        sort($files);

        return $files;
    }

    /**
     * Widgets that require this one directly.
     *
     * @return list<Widget>
     */
    public function dependents(Widget $widget): array
    {
        return array_values(array_filter($this->all(), static fn (Widget $other): bool => in_array($widget->name, $other->requires, true)));
    }

    /**
     * @return list<Example>
     */
    public function examples(Widget $widget): array
    {
        return array_map(function (string $slug) use ($widget): Example {
            $path = $this->path("resources/examples/{$widget->name}/{$slug}.blade.php");
            $source = is_file($path) ? (string) file_get_contents($path) : throw new InvalidArgumentException(
                "Widget [{$widget->name}] lists example [{$slug}], but resources/examples/{$widget->name}/{$slug}.blade.php is missing.",
            );

            $description = null;
            if (preg_match('/\A\s*\{\{--(.*?)--\}\}\s*/s', $source, $comment) === 1) {
                $description = trim((string) preg_replace('/\s+/', ' ', $comment[1]));
                $source = substr($source, strlen($comment[0]));
            }

            $dataPath = $this->path("resources/examples/{$widget->name}/{$slug}.data.php");
            $scriptPath = $this->path("resources/examples/{$widget->name}/{$slug}.js");

            return new Example(
                $widget->name,
                $slug,
                ucfirst(str_replace('-', ' ', $slug)),
                $description,
                rtrim($source)."\n",
                is_file($dataPath) ? $dataPath : null,
                is_file($scriptPath) ? rtrim((string) file_get_contents($scriptPath))."\n" : null,
            );
        }, $widget->examples);
    }

    /**
     * @return list<Snippet>
     */
    public function usage(Widget $widget): array
    {
        $extensions = ['blade.php' => 'blade', 'php' => 'php', 'js' => 'js'];

        return array_map(function (string $slug) use ($widget, $extensions): Snippet {
            $path = null;
            $language = null;
            foreach ($extensions as $extension => $candidate) {
                if (is_file($this->path("resources/usage/{$widget->name}/{$slug}.{$extension}"))) {
                    $path = $this->path("resources/usage/{$widget->name}/{$slug}.{$extension}");
                    $language = $candidate;
                    break;
                }
            }
            if ($path === null || $language === null) {
                throw new InvalidArgumentException("Widget [{$widget->name}] lists usage [{$slug}], but resources/usage/{$widget->name}/{$slug}.(blade.php|php|js) is missing.");
            }

            $source = (string) file_get_contents($path);
            // A leading {{-- … --}} in Blade, or leading // lines in PHP and JS, is the description.
            $pattern = $language === 'blade' ? '/\A\s*\{\{--(.*?)--\}\}\s*/s' : '/\A(?:\s*\/\/[^\n]*\n)+\s*/';
            $description = null;
            if (preg_match($pattern, $source, $comment) === 1) {
                $text = $language === 'blade' ? $comment[1] : (string) preg_replace('/^\s*\/\/ ?/m', '', $comment[0]);
                $description = trim((string) preg_replace('/\s+/', ' ', $text));
                $source = substr($source, strlen($comment[0]));
            }

            return new Snippet($widget->name, $slug, ucfirst(str_replace('-', ' ', $slug)), $description, $language, rtrim($source)."\n");
        }, $widget->usage);
    }

    /**
     * The widget's Blade components with the props each declares, read from their @props block, and the slots its
     * manifest lists for them. Assumes the house style of one prop per line, which every widget follows; the //
     * comment lines right above a prop are its description.
     *
     * @return list<Component>
     */
    public function components(Widget $widget): array
    {
        $components = [];
        foreach ($this->files($widget, 'views') as $file) {
            $tag = 'x-widget.'.str_replace(['/index.blade.php', '.blade.php', '/'], ['', '', '.'], "{$widget->name}/{$file}");
            $source = (string) file_get_contents($this->dir($widget, 'views').'/'.$file);

            $props = [];
            if (preg_match('/@props\(\[\s*\n(.*?)\n\s*\]\)/s', $source, $block) === 1) {
                $comment = [];
                foreach (explode("\n", $block[1]) as $line) {
                    if (preg_match('/^\s*\/\/\s?(.*)$/', $line, $text) === 1) {
                        $comment[] = trim($text[1]);
                    } elseif (preg_match("/^\\s*'([A-Za-z][A-Za-z0-9]*)'(?:\\s*=>\\s*(.+?))?,?\\s*$/", $line, $prop) === 1) {
                        $props[] = new Prop(Str::kebab($prop[1]), isset($prop[2]) ? $prop[2] : null, $comment === [] ? null : implode(' ', $comment));
                        $comment = [];
                    } else {
                        $comment = [];
                    }
                }
            }

            $components[] = new Component($tag, $file, $props, $widget->slots[$tag] ?? []);
        }

        // The widget's own tag first (x-widget.button), then the rest of its components (x-widget.button.back, …).
        usort($components, static fn (Component $a, Component $b): int => [substr_count($a->tag, '.'), $a->tag] <=> [substr_count($b->tag, '.'), $b->tag]);

        return $components;
    }

    /**
     * @param  list<string>  $trail  the chain that led here, to report cycles
     * @param  array<string, Widget>  $ordered
     */
    private function visit(string $name, array $trail, array &$ordered): void
    {
        if (isset($ordered[$name])) {
            return;
        }
        if (in_array($name, $trail, true)) {
            throw new LogicException('Widget requirements form a cycle: '.implode(' → ', [...$trail, $name]).'.');
        }

        $widget = $this->get($name);
        foreach ($widget->requires as $required) {
            $this->visit($required, [...$trail, $name], $ordered);
        }
        $ordered[$name] = $widget;
    }
}
