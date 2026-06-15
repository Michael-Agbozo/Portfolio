<?php

namespace App\Support;

/**
 * Cleans the HTML produced by the rich text editor before it is saved.
 * Uses only built-in PHP string functions — no ext-dom or ext-xml needed.
 */
class HtmlSanitizer
{
    private const ALLOWED_TAGS =
        '<p><br><strong><b><em><i><u><s>' .
        '<h2><h3><h4><ul><ol><li><a><blockquote><code><pre>';

    public static function clean(?string $html): ?string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return null;
        }

        // Strip every tag not on the allowlist (keeps inner text).
        $html = strip_tags($html, self::ALLOWED_TAGS);

        // Remove event-handler attributes (onclick, onmouseover, etc.).
        $html = preg_replace('/\s+on\w+\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]*)/i', '', $html);

        // Rewrite <a> tags: keep only a safe href, force blank/noopener.
        $html = preg_replace_callback('/<a(\s[^>]*)?>/i', function (array $m) {
            $attrs  = $m[1] ?? '';
            $href   = '';

            if (preg_match('/href\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s>]*))/i', $attrs, $hm)) {
                $raw    = $hm[1] ?: ($hm[2] ?: $hm[3]);
                $scheme = strtolower((string) parse_url($raw, PHP_URL_SCHEME));

                if ($scheme === '' || in_array($scheme, ['http', 'https', 'mailto', 'tel'], true)) {
                    $href = ' href="' . htmlspecialchars($raw, ENT_QUOTES | ENT_HTML5) . '"';
                }
            }

            return '<a' . $href . ' target="_blank" rel="noopener noreferrer">';
        }, $html);

        $html = trim($html);

        if ($html === '' || trim(strip_tags($html)) === '') {
            return null;
        }

        return $html;
    }
}
