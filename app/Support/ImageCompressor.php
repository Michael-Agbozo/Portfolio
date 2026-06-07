<?php

namespace App\Support;

/**
 * Shrinks large uploaded images down to a reasonable size and re-encodes
 * them at a slightly lower quality, so big photos don't eat up storage
 * while still looking sharp on the site. Skips files that are already
 * small, and skips GIFs (re-encoding would break their animation).
 */
class ImageCompressor
{
    public static function compress(string $absolutePath, int $maxWidth = 1920, int $quality = 75, int $skipBelowBytes = 512000): void
    {
        if (!is_file($absolutePath)) {
            return;
        }

        $info = @getimagesize($absolutePath);
        if (!$info) {
            return;
        }

        [$width, $height, $type] = $info;

        if ($type === IMAGETYPE_GIF) {
            return;
        }

        $needsResize = $width > $maxWidth;
        $needsRecompress = filesize($absolutePath) > $skipBelowBytes;

        if (!$needsResize && !$needsRecompress) {
            return;
        }

        // Decoding a large photo into GD as a raw bitmap can need far more than
        // PHP's default 128MB (a 24-megapixel photo alone needs ~100MB+), which
        // was crashing the whole save with a fatal "memory exhausted" error.
        // Temporarily raise the ceiling for this operation, then put it back.
        $previousLimit = ini_get('memory_limit');
        ini_set('memory_limit', '512M');

        try {
            $source = match ($type) {
                IMAGETYPE_JPEG => @imagecreatefromjpeg($absolutePath),
                IMAGETYPE_PNG  => @imagecreatefrompng($absolutePath),
                IMAGETYPE_WEBP => @imagecreatefromwebp($absolutePath),
                default        => null,
            };

            if (!$source) {
                return;
            }

            $image = $source;

            if ($needsResize) {
                $newWidth  = $maxWidth;
                $newHeight = (int) round($height * ($maxWidth / $width));

                $resized = imagecreatetruecolor($newWidth, $newHeight);

                if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                }

                imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                $image = $resized;
            }

            match ($type) {
                IMAGETYPE_JPEG => imagejpeg($image, $absolutePath, $quality),
                IMAGETYPE_PNG  => imagepng($image, $absolutePath, (int) round((100 - $quality) * 9 / 100)),
                IMAGETYPE_WEBP => imagewebp($image, $absolutePath, $quality),
                default        => null,
            };
        } finally {
            // PHP can't lower the limit below memory already in use, which would
            // otherwise emit a harmless-but-noisy warning here — silence it.
            @ini_set('memory_limit', $previousLimit);
        }
    }
}
