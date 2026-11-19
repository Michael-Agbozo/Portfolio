<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Shrinks uploaded book PDFs so the flipbook loads quickly on phones.
 *
 * Ghostscript re-saves the PDF with photos downsampled to screen quality
 * (150 dpi), so the reader can show page 1 without downloading most of the
 * book. Text stays sharp.
 * The original is only replaced when the result is clearly smaller, and
 * if Ghostscript isn't installed or fails, the original is kept as is.
 */
class PdfCompressor
{
    /** Only keep the shrunk copy if it saves at least 10%. */
    private const MIN_SAVING = 0.9;

    public static function compress(string $absolutePath): bool
    {
        // PHP-FPM may run without a PATH, so also look in the usual install folders.
        $gs = (new ExecutableFinder)->find('gs', null, ['/usr/bin', '/usr/local/bin', '/nix/var/nix/profiles/default/bin']);

        if (! $gs || ! is_file($absolutePath)) {
            return false;
        }

        // A 100 MB book can take a minute or two to process.
        set_time_limit(0);

        $temp = $absolutePath.'.'.uniqid().'.tmp';

        $process = new Process([
            $gs, '-q', '-dNOPAUSE', '-dBATCH', '-dSAFER',
            '-sDEVICE=pdfwrite',
            '-dCompatibilityLevel=1.6',
            '-dPDFSETTINGS=/ebook',
            '-sOutputFile='.$temp,
            $absolutePath,
        ]);
        $process->setTimeout(600);

        try {
            $process->run();
        } catch (\Throwable $e) {
            Log::warning('PDF compression failed', ['file' => $absolutePath, 'error' => $e->getMessage()]);
            @unlink($temp);

            return false;
        }

        $originalSize = filesize($absolutePath);
        $newSize = is_file($temp) ? filesize($temp) : 0;

        if (! $process->isSuccessful() || $newSize === 0 || ! self::looksLikePdf($temp) || $newSize > $originalSize * self::MIN_SAVING) {
            @unlink($temp);

            return false;
        }

        rename($temp, $absolutePath);
        Log::info('PDF compressed', ['file' => basename($absolutePath), 'from' => $originalSize, 'to' => $newSize]);

        return true;
    }

    private static function looksLikePdf(string $path): bool
    {
        $handle = fopen($path, 'rb');
        $start = fread($handle, 5);
        fclose($handle);

        return $start === '%PDF-';
    }
}
