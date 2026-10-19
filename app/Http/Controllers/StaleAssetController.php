<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

/**
 * Every deploy gives the built CSS/JS files new names (e.g. emerald-AbC12345.css).
 * A page that was already open, or restored from the browser's memory, still asks
 * for the old name and would show up unstyled. Only missing files reach this
 * controller; it points them to the current file of the same name.
 */
class StaleAssetController extends Controller
{
    public function __invoke(string $asset): RedirectResponse
    {
        if (! preg_match('/^(?<name>.+?)-[A-Za-z0-9_-]{8}\.(?<ext>css|js)$/', $asset, $old)) {
            abort(404);
        }

        $manifestPath = public_path('build/manifest.json');
        $manifest = is_file($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : null;

        foreach ((array) $manifest as $entry) {
            foreach (array_merge([$entry['file'] ?? null], $entry['css'] ?? []) as $file) {
                if ($file && $this->sameAsset(basename($file), $old['name'], $old['ext']) && basename($file) !== $asset) {
                    return redirect(asset('build/'.$file), 302)->header('Cache-Control', 'no-store');
                }
            }
        }

        abort(404);
    }

    private function sameAsset(string $file, string $name, string $ext): bool
    {
        return (bool) preg_match('/^'.preg_quote($name, '/').'-[A-Za-z0-9_-]{8}\.'.$ext.'$/', $file);
    }
}
