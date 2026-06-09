<?php

namespace App\Support;

/**
 * An image field can hold either a full URL (https://cdn.example.com/x.jpg)
 * or a local /storage/... path (from an upload or the media library picker).
 * Both controllers that accept image paths need to recognise either form.
 */
class ImagePathValidator
{
    public static function isValid(string $value): bool
    {
        $scheme = parse_url($value, PHP_URL_SCHEME);
        $isUrl = filter_var($value, FILTER_VALIDATE_URL) !== false
            && in_array($scheme, ['http', 'https'], true);

        $isStorage = ! str_contains($value, '..')
            && (bool) preg_match('#^/storage/[A-Za-z0-9._/-]+$#', $value);

        return $isUrl || $isStorage;
    }
}
