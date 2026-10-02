<?php

declare(strict_types=1);

namespace LarawellUi;

/**
 * What larawell:add checks in the app's front end before copying anything: the widgets are written for
 * Tailwind CSS 4.1+ built by Vite, and on anything older they install fine and then look broken.
 */
final readonly class Requirements
{
    public const string TAILWIND = '4.1';

    /**
     * @param  list<string>  $errors  stop the install
     * @param  list<string>  $warnings  can't be confirmed either way, so the install goes ahead
     */
    public function __construct(
        public array $errors,
        public array $warnings,
    ) {}

    public static function check(string $basePath): self
    {
        $manifest = self::json($basePath.'/package.json');
        if ($manifest === null) {
            return new self([], ['No package.json found, so Tailwind CSS '.self::TAILWIND.'+ and Vite could not be checked.']);
        }

        $dependencies = [];
        foreach (['dependencies', 'devDependencies', 'optionalDependencies'] as $key) {
            if (is_array($manifest[$key] ?? null)) {
                $dependencies += array_filter($manifest[$key], is_string(...));
            }
        }

        $errors = [];
        $warnings = [];

        // The installed version is the truth; the declared range only stands in before npm install. A fresh
        // Laravel app declares ^4.0.0, which installs 4.1+, so a range only fails when it can't reach 4.1.
        $installed = self::json($basePath.'/node_modules/tailwindcss/package.json')['version'] ?? null;
        if (is_string($installed)) {
            if (version_compare($installed, self::TAILWIND, '<')) {
                $errors[] = "Tailwind CSS {$installed} is installed; the widgets need ".self::TAILWIND.'+. Run npm install tailwindcss@latest @tailwindcss/vite@latest.';
            }
        } elseif (isset($dependencies['tailwindcss'])) {
            if (!self::reaches($dependencies['tailwindcss'], self::TAILWIND)) {
                $errors[] = "package.json asks for tailwindcss {$dependencies['tailwindcss']}; the widgets need ".self::TAILWIND.'+. Run npm install tailwindcss@latest @tailwindcss/vite@latest.';
            }
        } else {
            $warnings[] = 'Tailwind CSS is not in package.json. The widgets are styled with Tailwind CSS '.self::TAILWIND.'+, so add it before building.';
        }

        if (!isset($dependencies['vite'])) {
            $warnings[] = 'Vite is not in package.json. The widget scripts and styles are imported from resources/js/app.js and resources/css/app.css, which Vite builds.';
        }

        return new self($errors, $warnings);
    }

    /**
     * Whether a version range from package.json allows $minimum or later. Covers the shapes npm writes and people
     * type: ^4.0.0, ~4.1.2, >=4.1, 4.0.3, 4.x, *, latest. Anything unrecognised gets the benefit of the doubt.
     */
    private static function reaches(string $range, string $minimum): bool
    {
        $range = trim($range);
        if (preg_match('/^(\^|~|>=?)?\s*v?(\d+)(?:\.(\d+|x|\*))?/i', $range, $m) !== 1) {
            return true;
        }

        [$major, $minor] = [(int) $m[2], isset($m[3]) && is_numeric($m[3]) ? (int) $m[3] : null];
        [$wantMajor, $wantMinor] = array_map(intval(...), explode('.', $minimum));

        return match (true) {
            str_starts_with($m[1], '>') => true,
            // ^ stays within the major, so ^4.0 reaches 4.1 and ^3.4 never does.
            $m[1] === '^', $minor === null => $major >= $wantMajor,
            // ~ and an exact version stay within the minor.
            default => $major > $wantMajor || ($major === $wantMajor && $minor >= $wantMinor),
        };
    }

    /**
     * @return array<mixed>|null
     */
    private static function json(string $path): ?array
    {
        if (!is_file($path)) {
            return null;
        }
        $data = json_decode((string) file_get_contents($path), true);

        return is_array($data) ? $data : null;
    }
}
