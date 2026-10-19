<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SimplyPerfectGalleryMigrationTest extends TestCase
{
    use RefreshDatabase;

    private function runMigration(): void
    {
        (require database_path('migrations/2026_10_19_000001_add_simply_perfect_gallery_screenshots.php'))->up();
    }

    public function test_screenshots_are_added_to_the_gallery_and_shown_on_the_project_page(): void
    {
        Storage::fake('public');
        $this->runMigration();

        $project = Project::where('slug', 'simply-perfect')->firstOrFail();

        $this->assertContains('/storage/projects/simply-perfect-print-shop.jpg', $project->images);
        $this->assertNotContains('/storage/projects/simply-perfect-mobile.jpg', $project->images);
        Storage::disk('public')->assertExists('projects/simply-perfect-product.jpg');

        $this->get(route('project.show', $project))
            ->assertOk()
            ->assertSee('/storage/projects/simply-perfect-cutline.jpg', false);
    }

    public function test_dashboard_images_are_kept_and_running_twice_adds_no_duplicates(): void
    {
        Storage::fake('public');
        $project = Project::where('slug', 'simply-perfect')->firstOrFail();
        $project->update(['images' => ['/storage/projects/my-own-upload.jpg']]);

        $this->runMigration();
        $this->runMigration();

        $images = $project->fresh()->images;
        $this->assertSame('/storage/projects/my-own-upload.jpg', $images[0]);
        $this->assertCount(6, $images);
        $this->assertCount(6, array_unique($images));
    }

    public function test_cleanup_removes_an_already_added_phone_screenshot_and_keeps_the_rest(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('projects/simply-perfect-mobile.jpg', 'x');
        $project = Project::where('slug', 'simply-perfect')->firstOrFail();
        $project->update(['images' => [
            '/storage/projects/simply-perfect-site.jpg',
            '/storage/projects/simply-perfect-mobile.jpg',
            '/storage/projects/simply-perfect-about.jpg',
        ]]);

        (require database_path('migrations/2026_10_19_000002_remove_simply_perfect_mobile_screenshot.php'))->up();

        $this->assertSame([
            '/storage/projects/simply-perfect-site.jpg',
            '/storage/projects/simply-perfect-about.jpg',
        ], $project->fresh()->images);
        Storage::disk('public')->assertMissing('projects/simply-perfect-mobile.jpg');
    }

    public function test_does_nothing_when_the_project_is_missing(): void
    {
        Storage::fake('public');
        Project::query()->forceDelete();

        $this->runMigration();

        $this->assertSame(0, Project::count());
    }
}
