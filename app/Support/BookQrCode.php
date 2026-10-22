<?php

namespace App\Support;

use App\Models\Book;
use BaconQrCode\Renderer\GDLibRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

/**
 * QR codes that open a book's public reader.
 *
 * PNG is sized for printing; SVG stays sharp at any size for designers.
 */
class BookQrCode
{
    public const FORMATS = ['png', 'svg'];

    private const SIZE = 1200;

    private const MARGIN = 2;

    public static function make(Book $book, string $format): string
    {
        $renderer = $format === 'svg'
            ? new ImageRenderer(new RendererStyle(self::SIZE, self::MARGIN), new SvgImageBackEnd)
            : new GDLibRenderer(self::SIZE, self::MARGIN);

        return (new Writer($renderer))->writeString($book->readerUrl());
    }

    public static function mimeType(string $format): string
    {
        return $format === 'svg' ? 'image/svg+xml' : 'image/png';
    }
}
