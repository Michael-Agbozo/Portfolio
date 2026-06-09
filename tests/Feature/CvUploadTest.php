<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CvUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_a_new_cv(): void
    {
        $path = public_path('cv/michael-agbozo-cv.pdf');
        $directory = dirname($path);
        $backup = is_file($path) ? file_get_contents($path) : null;

        try {
            $user = User::factory()->create();
            $file = UploadedFile::fake()->create('updated-cv.pdf', 100, 'application/pdf');

            $response = $this->actingAs($user)->post(route('dashboard.cv.update'), [
                'cv' => $file,
            ]);

            $response->assertSessionHas('success');
            $this->assertFileExists($path);
        } finally {
            if ($backup !== null) {
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                file_put_contents($path, $backup);
            } elseif (is_file($path)) {
                unlink($path);
            }
        }
    }
}
