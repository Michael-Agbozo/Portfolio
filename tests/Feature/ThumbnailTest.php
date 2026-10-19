<?php

namespace Tests\Feature;

use App\Support\Thumbnail;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ThumbnailTest extends TestCase
{
    private string $source;

    protected function setUp(): void
    {
        parent::setUp();

        $this->source = storage_path('app/public/thumbtest-'.uniqid().'.jpg');
        $image = imagecreatetruecolor(1200, 800);
        imagefill($image, 0, 0, imagecolorallocate($image, 45, 227, 167));
        imagejpeg($image, $this->source, 90);
        imagedestroy($image);
    }

    protected function tearDown(): void
    {
        File::delete($this->source);
        File::deleteDirectory(storage_path('app/public/thumbs'));
        parent::tearDown();
    }

    private function src(): string
    {
        return '/storage/'.basename($this->source);
    }

    public function test_a_resized_webp_copy_is_made_and_served(): void
    {
        $url = Thumbnail::url($this->src(), 640);

        $this->assertStringStartsWith('/storage/thumbs/640/', $url);
        $this->assertStringEndsWith('.jpg.webp', $url);

        $response = $this->get($url);
        $response->assertOk()->assertHeader('Content-Type', 'image/webp');

        [$width] = getimagesizefromstring(file_get_contents($response->baseResponse->getFile()->getPathname()));
        $this->assertSame(640, $width);
    }

    public function test_srcset_lists_each_width(): void
    {
        $srcset = Thumbnail::srcset($this->src(), [400, 640]);

        $this->assertStringContainsString('/storage/thumbs/400/', $srcset);
        $this->assertStringContainsString(' 400w', $srcset);
        $this->assertStringContainsString(' 640w', $srcset);
    }

    public function test_external_or_unknown_images_keep_their_original_url(): void
    {
        $this->assertSame('https://cdn.example.com/a.jpg', Thumbnail::url('https://cdn.example.com/a.jpg', 640));
        $this->assertSame('/storage/missing.jpg', Thumbnail::url('/storage/missing.jpg', 640));
        $this->assertSame($this->src(), Thumbnail::url($this->src(), 333));
        $this->assertNull(Thumbnail::url(null, 640));
    }

    public function test_bad_requests_are_refused(): void
    {
        $version = filemtime($this->source);
        $file = 'storage/'.basename($this->source).'.webp';

        $this->get("/storage/thumbs/333/{$version}/{$file}")->assertNotFound();
        $this->get("/storage/thumbs/640/1/{$file}")->assertNotFound();
        $this->get("/storage/thumbs/640/{$version}/storage/../../.env.webp")->assertNotFound();
        $this->get("/storage/thumbs/640/{$version}/storage/thumbs/x.jpg.webp")->assertNotFound();
    }
}
