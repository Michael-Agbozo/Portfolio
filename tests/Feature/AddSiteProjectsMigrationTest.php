<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddSiteProjectsMigrationTest extends TestCase
{
    use RefreshDatabase;

    private function runMigration(): void
    {
        (require database_path('migrations/2026_10_15_000001_add_safe_hand_and_simply_perfect_projects.php'))->up();
    }

    public function test_both_projects_are_live_with_links_and_screenshots(): void
    {
        $simplyPerfect = Project::where('slug', 'simply-perfect')->firstOrFail();
        $safeHand = Project::where('slug', 'safe-hand-transport')->firstOrFail();

        $this->assertSame('https://www.simplyperfect.be/', $simplyPerfect->url);
        $this->assertSame('/storage/projects/simply-perfect-site.jpg', $simplyPerfect->feature_image);
        $this->assertSame('https://safehandtransport.net/', $safeHand->url);
        $this->assertTrue($simplyPerfect->active);

        $this->get('/')->assertOk()->assertSee('Simply Perfect')->assertSee('Safe Hand Transport');
        $this->get(route('project.show', $simplyPerfect))->assertOk()->assertSee('simplyperfect.be');
    }

    public function test_existing_safe_hand_project_is_filled_in_without_overwriting_or_duplicating(): void
    {
        Project::query()->forceDelete();
        Project::create([
            'num' => '04', 'category' => 'development', 'title' => 'Safe Hand Transport',
            'slug' => 'safe-hand-transport', 'meta' => 'Existing', 'tags' => [],
            'feature_image' => '/storage/projects/custom.jpg',
        ]);

        $this->runMigration();
        $this->runMigration();

        $safeHand = Project::where('slug', 'safe-hand-transport')->sole();
        $this->assertSame('https://safehandtransport.net/', $safeHand->url);
        $this->assertSame('/storage/projects/custom.jpg', $safeHand->feature_image);
        $this->assertSame(1, Project::where('slug', 'simply-perfect')->count());
        $this->assertSame('05', Project::where('slug', 'simply-perfect')->value('num'));
    }
}
