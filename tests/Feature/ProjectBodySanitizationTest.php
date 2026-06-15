<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectBodySanitizationTest extends TestCase
{
    use RefreshDatabase;

    private function baseProjectData(array $overrides = []): array
    {
        return array_merge([
            'num' => '01',
            'category' => 'development',
            'title' => 'Sanitization Test',
            'meta' => 'A test project',
            'tags' => '',
            'images' => '',
            'url' => '',
        ], $overrides);
    }

    public function test_allowed_formatting_tags_are_kept(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('dashboard.projects.store'), $this->baseProjectData([
            'body' => '<h2>Overview</h2><p>This project was <strong>great</strong>.</p><ul><li>One</li><li>Two</li></ul>',
        ]));

        $project = Project::where('title', 'Sanitization Test')->first();

        $this->assertStringContainsString('<h2>Overview</h2>', $project->body);
        $this->assertStringContainsString('<strong>great</strong>', $project->body);
        $this->assertStringContainsString('<li>One</li>', $project->body);
    }

    public function test_scripts_and_event_handlers_are_stripped(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('dashboard.projects.store'), $this->baseProjectData([
            'body' => '<p onclick="alert(1)">Hello</p><script>alert(2)</script>',
        ]));

        $project = Project::where('title', 'Sanitization Test')->first();

        $this->assertStringNotContainsString('<script', $project->body);
        $this->assertStringNotContainsString('onclick', $project->body);
        $this->assertStringContainsString('<p>Hello</p>', $project->body);
    }

    public function test_unsafe_link_schemes_are_removed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('dashboard.projects.store'), $this->baseProjectData([
            'body' => '<p><a href="javascript:alert(1)">click</a> <a href="https://example.com">safe</a></p>',
        ]));

        $project = Project::where('title', 'Sanitization Test')->first();

        $this->assertStringNotContainsString('javascript:', $project->body);
        $this->assertStringContainsString('href="https://example.com"', $project->body);
    }

    public function test_empty_body_is_stored_as_null(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('dashboard.projects.store'), $this->baseProjectData([
            'body' => '<p><br></p>',
        ]));

        $project = Project::where('title', 'Sanitization Test')->first();

        $this->assertNull($project->body);
    }
}
