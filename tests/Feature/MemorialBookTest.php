<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MemorialBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_memorial_book_upload_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.memorial-book.show'))
            ->assertOk()
            ->assertSee('Memorial Book')
            ->assertSee('/dadaa-kate-dzidzornu-nyamadi-funeral-ebook', false);
    }

    public function test_public_reader_is_not_available_before_upload(): void
    {
        $path = public_path('memorial/dadaa-kate-dzidzornu-nyamadi-funeral-ebook.pdf');
        $backup = is_file($path) ? file_get_contents($path) : null;

        try {
            if (is_file($path)) {
                unlink($path);
            }

            $this->get(route('memorial.book'))->assertNotFound();
        } finally {
            if ($backup !== null) {
                if (!is_dir(dirname($path))) {
                    mkdir(dirname($path), 0755, true);
                }

                file_put_contents($path, $backup);
            }
        }
    }

    public function test_admin_can_upload_memorial_book(): void
    {
        $path = public_path('memorial/dadaa-kate-dzidzornu-nyamadi-funeral-ebook.pdf');
        $directory = dirname($path);
        $pagesDirectory = public_path('memorial/pages');
        $oldPagePath = $pagesDirectory.'/page-99.jpg';
        $backup = is_file($path) ? file_get_contents($path) : null;
        $pageBackups = $this->backupPageImages($pagesDirectory);

        try {
            if (!is_dir($pagesDirectory)) {
                mkdir($pagesDirectory, 0755, true);
            }
            file_put_contents($oldPagePath, 'old-page');

            $user = User::factory()->create();
            $file = UploadedFile::fake()->create('funeral-book.pdf', 100, 'application/pdf');

            $response = $this->actingAs($user)->post(route('dashboard.memorial-book.update'), [
                'book' => $file,
            ]);

            $response->assertSessionHas('success');
            $this->assertFileExists($path);
            $this->assertFileDoesNotExist($oldPagePath);
            $this->get(route('memorial.book'))
                ->assertOk()
                ->assertSee('Dadaa Kate Dzidzornu Nyamadi Funeral Ebook')
                ->assertSee('/memorial/dadaa-kate-dzidzornu-nyamadi-funeral-ebook.pdf', false)
                ->assertDontSee('Michael Agbozo<span class="text-orange">.</span>', false);
        } finally {
            if ($backup !== null) {
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                file_put_contents($path, $backup);
            } elseif (is_file($path)) {
                unlink($path);
            }

            if (is_file($oldPagePath)) {
                unlink($oldPagePath);
            }

            $this->restorePageImages($pagesDirectory, $pageBackups);
        }
    }

    public function test_public_reader_uses_flipbook_when_page_images_exist(): void
    {
        $pagesDirectory = public_path('memorial/pages');
        $testPagePath = $pagesDirectory.'/page-99.jpg';
        $pageBackups = $this->backupPageImages($pagesDirectory);

        try {
            if (!is_dir($pagesDirectory)) {
                mkdir($pagesDirectory, 0755, true);
            }
            file_put_contents($testPagePath, 'test-page');

            $this->get(route('memorial.book'))
                ->assertOk()
                ->assertSee('data-book', false)
                ->assertSee('data-flip-sheet', false)
                ->assertSee('data-next', false)
                ->assertSee('corner-turn', false)
                ->assertSee('turn-cue', false)
                ->assertSee('playTurnSound', false);
        } finally {
            $this->restorePageImages($pagesDirectory, $pageBackups);
        }
    }

    public function test_iet_induction_reader_uses_its_own_book_assets(): void
    {
        $this->get(route('iet.induction.book'))
            ->assertOk()
            ->assertSee('IET-GH Induction Of New Members')
            ->assertSee('iet-gh-induction-of-new-members.pdf', false)
            ->assertSee('page-01.jpg', false)
            ->assertDontSee('/memorial/dadaa-kate-dzidzornu-nyamadi-funeral-ebook.pdf', false);
    }

    private function backupPageImages(string $pagesDirectory): array
    {
        $backups = [];

        foreach (glob($pagesDirectory.'/page-*.jpg') ?: [] as $pageImage) {
            if (is_file($pageImage)) {
                $backups[basename($pageImage)] = file_get_contents($pageImage);
            }
        }

        return $backups;
    }

    private function restorePageImages(string $pagesDirectory, array $backups): void
    {
        if (!is_dir($pagesDirectory)) {
            mkdir($pagesDirectory, 0755, true);
        }

        foreach (glob($pagesDirectory.'/page-*.jpg') ?: [] as $pageImage) {
            if (is_file($pageImage)) {
                unlink($pageImage);
            }
        }

        foreach ($backups as $filename => $contents) {
            file_put_contents($pagesDirectory.'/'.$filename, $contents);
        }
    }
}
