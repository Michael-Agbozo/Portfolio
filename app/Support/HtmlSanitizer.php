<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Cleans the HTML produced by the rich text editor on the project's "Full
 * Description" field before it is saved. Only a small allowlist of
 * formatting tags/attributes survives — everything else (scripts, styles,
 * event handlers, javascript: links, etc.) is stripped so saved content
 * can be safely rendered on the public project page.
 */
class HtmlSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's',
        'h2', 'h3', 'h4',
        'ul', 'ol', 'li',
        'a', 'blockquote', 'code', 'pre',
    ];

    private const ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'target', 'rel'],
    ];

    public static function clean(?string $html): ?string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return null;
        }

        $document = new DOMDocument();
        // Wrap in a root element and force UTF-8 so DOMDocument doesn't
        // mangle special characters or emit a <!DOCTYPE>/<html> wrapper.
        $document->loadHTML(
            '<?xml encoding="utf-8"?><div id="sanitizer-root">' . $html . '</div>',
            LIBXML_NOERROR | LIBXML_NOWARNING
        );

        $root = $document->getElementById('sanitizer-root');

        self::cleanChildren($document, $root);

        $output = '';
        foreach (iterator_to_array($root->childNodes) as $child) {
            $output .= $document->saveHTML($child);
        }

        $output = trim($output);

        // Treat content with no visible text (e.g. an empty "<p><br></p>"
        // left over from the rich text editor) as no description at all.
        if ($output === '' || trim(strip_tags($output)) === '') {
            return null;
        }

        return $output;
    }

    private static function cleanChildren(DOMDocument $document, DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    // Unwrap disallowed tags: keep their children/text but
                    // drop the wrapping element (e.g. <script>, <span>, <div>).
                    self::cleanChildren($document, $child);

                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }

                    $node->removeChild($child);
                    continue;
                }

                self::cleanAttributes($child);
                self::cleanChildren($document, $child);
            }
        }
    }

    private static function cleanAttributes(DOMElement $element): void
    {
        $tag = strtolower($element->tagName);
        $allowed = self::ALLOWED_ATTRIBUTES[$tag] ?? [];

        foreach (iterator_to_array($element->attributes) as $attribute) {
            $name = strtolower($attribute->name);

            if (! in_array($name, $allowed, true)) {
                $element->removeAttribute($attribute->name);
                continue;
            }

            if ($name === 'href' && self::hasUnsafeScheme($attribute->value)) {
                $element->removeAttribute('href');
            }
        }

        if ($tag === 'a' && $element->hasAttribute('href')) {
            $element->setAttribute('target', '_blank');
            $element->setAttribute('rel', 'noopener noreferrer');
        }
    }

    private static function hasUnsafeScheme(string $href): bool
    {
        $href = trim($href);
        $scheme = strtolower((string) parse_url($href, PHP_URL_SCHEME));

        return $scheme !== '' && ! in_array($scheme, ['http', 'https', 'mailto', 'tel'], true);
    }
}
