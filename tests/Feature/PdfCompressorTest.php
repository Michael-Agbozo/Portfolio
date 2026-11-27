<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use App\Support\PdfCompressor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\ExecutableFinder;
use Tests\TestCase;

class PdfCompressorTest extends TestCase
{
    use RefreshDatabase;

    private string $dir;

    protected function setUp(): void
    {
        parent::setUp();

        if (! (new ExecutableFinder)->find('gs')) {
            $this->markTestSkipped('Ghostscript is not installed.');
        }

        $this->dir = storage_path('framework/testing/pdf-'.uniqid());
        mkdir($this->dir, 0775, true);
    }

    protected function tearDown(): void
    {
        array_map('unlink', glob($this->dir.'/*') ?: []);
        @rmdir($this->dir);
        parent::tearDown();
    }

    public function test_a_photo_heavy_pdf_is_shrunk(): void
    {
        $path = $this->dir.'/book.pdf';
        file_put_contents($path, $this->photoPdf());
        $before = filesize($path);

        $this->assertTrue(PdfCompressor::compress($path));

        clearstatcache();
        $this->assertLessThan($before * 0.9, filesize($path));
        $this->assertStringStartsWith('%PDF-', file_get_contents($path, false, null, 0, 5));
    }

    public function test_a_broken_file_is_left_untouched(): void
    {
        $path = $this->dir.'/broken.pdf';
        file_put_contents($path, 'not really a pdf');

        $this->assertFalse(PdfCompressor::compress($path));
        $this->assertSame('not really a pdf', file_get_contents($path));
        $this->assertCount(1, glob($this->dir.'/*'));
    }

    public function test_uploaded_book_pdf_is_shrunk_after_saving(): void
    {
        Storage::fake('public');
        $path = $this->dir.'/upload.pdf';
        file_put_contents($path, $this->photoPdf());
        $before = filesize($path);

        $this->actingAs(User::factory()->create())
            ->post(route('dashboard.books.store'), [
                'title' => 'Annual Meeting',
                'pdf' => new UploadedFile($path, 'meeting.pdf', 'application/pdf', null, true),
            ])
            ->assertRedirect();

        $this->assertLessThan($before * 0.9, Storage::disk('public')->size(Book::where('slug', 'annual-meeting')->firstOrFail()->pdf_path));
    }

    /** A one-page PDF holding a large, high-quality photo, like a scanned brochure page. */
    private function photoPdf(): string
    {
        $image = imagecreatetruecolor(3000, 4000);
        for ($y = 0; $y < 4000; $y += 4) {
            for ($x = 0; $x < 3000; $x += 4) {
                imagefilledrectangle($image, $x, $y, $x + 3, $y + 3, imagecolorallocate($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)));
            }
        }
        ob_start();
        imagejpeg($image, null, 95);
        $jpeg = ob_get_clean();
        imagedestroy($image);

        $content = "q 595 0 0 842 0 0 cm /Im1 Do Q";
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /XObject << /Im1 4 0 R >> >> /Contents 5 0 R >>',
            "<< /Type /XObject /Subtype /Image /Width 3000 /Height 4000 /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length ".strlen($jpeg)." >>\nstream\n".$jpeg."\nendstream",
            '<< /Length '.strlen($content)." >>\nstream\n".$content."\nendstream",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [];
        foreach ($objects as $i => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($i + 1)." 0 obj\n".$object."\nendobj\n";
        }
        $xref = strlen($pdf);
        $pdf .= "xref\n0 ".(count($objects) + 1)."\n0000000000 65535 f \n";
        foreach ($offsets as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        return $pdf."trailer\n<< /Size ".(count($objects) + 1)." /Root 1 0 R >>\nstartxref\n".$xref."\n%%EOF\n";
    }
}
