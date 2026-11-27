<?php

namespace Tests\Feature;

use App\Models\Design;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_picker_upload_saves_the_image_and_returns_its_storage_path(): void
    {
        Storage::fake('public');

        $response = $this->actingAs(User::factory()->create())
            ->post(route('dashboard.upload.temp'), ['file' => UploadedFile::fake()->image('photo.jpg', 800, 600)]);

        $path = $response->assertOk()->json('path');

        $this->assertStringStartsWith('/storage/media/', $path);
        Storage::disk('public')->assertExists(substr($path, strlen('/storage/')));
    }

    public function test_uploaded_design_image_is_saved_under_designs(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())
            ->post(route('dashboard.designs.store'), [
                'image' => UploadedFile::fake()->image('poster.png', 600, 900),
                'alt' => 'Poster',
            ])
            ->assertRedirect(route('dashboard.designs.index'));

        $src = Design::firstOrFail()->src;

        $this->assertStringStartsWith('/storage/designs/', $src);
        Storage::disk('public')->assertExists(substr($src, strlen('/storage/')));
    }
}
