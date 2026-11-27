<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KingdomProjectsMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_both_kingdom_projects_are_live_with_desktop_screenshots(): void
    {
        $mentorship = Project::where('slug', 'kingdom-life-mentorship')->firstOrFail();
        $academy = Project::where('slug', 'kingdom-arts-academy')->firstOrFail();

        $this->assertSame('https://kingdomlifementorship.com/', $mentorship->url);
        $this->assertSame('https://thekingdomartsacademy.com/', $academy->url);
        $this->assertSame('/storage/projects/kingdom-life-mentorship-site.jpg', $mentorship->feature_image);
        $this->assertSame('/storage/projects/kingdom-arts-academy-home.jpg', $academy->images[0]);
        $this->assertCount(13, $mentorship->images);
        $this->assertContains('/storage/projects/kingdom-life-mentorship-checkout.jpg', $mentorship->images);
        $this->assertCount(8, $academy->images);
        $this->assertTrue($academy->active);
        $this->assertNotSame($mentorship->num, $academy->num);

        $this->get('/')->assertOk()->assertSee('Kingdom Life Mentorship')->assertSee('Kingdom Arts Academy');
        $this->get(route('project.show', $academy))->assertOk()->assertSee('thekingdomartsacademy.com');
    }

    public function test_running_again_does_not_duplicate_or_overwrite_edits(): void
    {
        Project::where('slug', 'kingdom-arts-academy')->update(['feature_image' => '/storage/projects/custom.jpg']);

        (require database_path('migrations/2026_11_27_000001_add_kingdom_life_and_kingdom_arts_projects.php'))->up();

        $this->assertSame(1, Project::where('slug', 'kingdom-arts-academy')->count());
        $this->assertSame('/storage/projects/custom.jpg', Project::where('slug', 'kingdom-arts-academy')->value('feature_image'));
        $this->assertCount(13, Project::where('slug', 'kingdom-life-mentorship')->firstOrFail()->images);
    }
}
