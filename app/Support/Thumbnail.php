<?php

namespace App\Support;

/**
 * Smaller WebP copies of site images, sized for how big they are shown.
 *
 * A copy is made the first time its URL is requested (see ThumbnailController)
 * and saved under storage/app/public/thumbs, so afterwards nginx serves it
 * directly. The source file's modified time is part of the URL, so replacing
 * an image automatically gives it a fresh copy. Originals are never changed.
 */
class Thumbnail
{
    public const WIDTHS = [240, 400, 480, 640, 800, 960, 1280];

    private const QUALITY = 72;

    /** URL of a resized copy, or the original URL when it can't be resized. */
    public static function url(?string $src, int $width): ?string
    {
        $relative = self::relativePath($src);
        $source = $relative ? self::sourcePath($relative) : null;

        if (! $source || ! in_array($width, self::WIDTHS, true) || ! self::supported()) {
            return $src;
        }

        return '/storage/thumbs/'.$width.'/'.filemtime($source).'/'.$relative.'.webp';
    }

    /** A srcset list ("url 400w, url 640w") for responsive images. */
    public static function srcset(?string $src, array $widths): ?string
    {
        $relative = self::relativePath($src);

        if (! $relative || ! self::sourcePath($relative) || ! self::supported()) {
            return null;
        }

        return collect($widths)
            ->map(fn (int $w) => self::url($src, $w).' '.$w.'w')
            ->implode(', ');
    }

    /** [width, height] of the original image, for reserving space on the page. */
    public static function dimensions(?string $src): ?array
    {
        $relative = self::relativePath($src);
        $source = $relative ? self::sourcePath($relative) : null;
        $info = $source ? @getimagesize($source) : false;

        return $info ? [$info[0], $info[1]] : null;
    }

    /**
     * Absolute path of a site image under public/storage or public/images,
     * or null for anything else (other folders, missing files, non-images).
     */
    public static function sourcePath(string $relative): ?string
    {
        if (! preg_match('#^(storage|images)/[^\0]+\.(jpe?g|png|webp)$#i', $relative) || str_starts_with($relative, 'storage/thumbs/')) {
            return null;
        }

        $real = realpath(public_path($relative));
        $allowed = array_filter([
            realpath(storage_path('app/public')),
            realpath(public_path('images')),
        ]);

        foreach ($allowed as $root) {
            if ($real && str_starts_with($real, $root.DIRECTORY_SEPARATOR) && is_file($real)) {
                return $real;
            }
        }

        return null;
    }

    /** Write a resized WebP copy of $source to $target. Returns false on failure. */
    public static function make(string $source, string $target, int $width): bool
    {
        $info = @getimagesize($source);

        if (! $info) {
            return false;
        }

        ini_set('memory_limit', '1024M');

        $image = match ($info[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($source),
            IMAGETYPE_PNG => @imagecreatefrompng($source),
            IMAGETYPE_WEBP => @imagecreatefromwebp($source),
            default => null,
        };

        if (! $image) {
            return false;
        }

        [$w, $h] = [$info[0], $info[1]];

        if ($w > $width) {
            $newHeight = (int) round($h * $width / $w);
            $resized = imagecreatetruecolor($width, $newHeight);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $width, $newHeight, $w, $h);
            imagedestroy($image);
            $image = $resized;
        } else {
            imagepalettetotruecolor($image);
            imagealphablending($image, false);
            imagesavealpha($image, true);
        }

        if (! is_dir(dirname($target))) {
            mkdir(dirname($target), 0775, true);
        }

        $temp = $target.'.'.uniqid().'.tmp';
        $ok = imagewebp($image, $temp, self::QUALITY);
        imagedestroy($image);

        return $ok && rename($temp, $target);
    }

    /** Whether this server's PHP can write WebP files (otherwise originals are used). */
    public static function supported(): bool
    {
        return function_exists('imagewebp') && function_exists('imagecreatefromjpeg');
    }

    private static function relativePath(?string $src): ?string
    {
        if (! $src) {
            return null;
        }

        if (preg_match('#^https?://#i', $src)) {
            $host = parse_url($src, PHP_URL_HOST);

            if ($host !== parse_url(config('app.url'), PHP_URL_HOST) && $host !== request()->getHost()) {
                return null;
            }

            $src = (string) parse_url($src, PHP_URL_PATH);
        }

        return ltrim(rawurldecode($src), '/') ?: null;
    }
}
