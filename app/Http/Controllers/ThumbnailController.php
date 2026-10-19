<?php

namespace App\Http\Controllers;

use App\Support\Thumbnail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Makes a resized WebP copy the first time it is requested. Once saved,
 * nginx serves the file directly and this controller is no longer reached.
 */
class ThumbnailController extends Controller
{
    public function __invoke(int $width, int $version, string $path): BinaryFileResponse
    {
        abort_unless(in_array($width, Thumbnail::WIDTHS, true) && str_ends_with($path, '.webp'), 404);

        $source = Thumbnail::sourcePath(substr($path, 0, -5));
        abort_unless($source && filemtime($source) === $version, 404);

        $target = Storage::disk('public')->path("thumbs/{$width}/{$version}/{$path}");

        if (! is_file($target)) {
            abort_unless(Thumbnail::make($source, $target, $width), 404);
        }

        return response()->file($target, [
            'Content-Type' => 'image/webp',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }
}
