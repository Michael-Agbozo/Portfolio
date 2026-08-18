<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectEditorTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_form_loads_the_visible_rich_text_editor_host(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard.projects.create'));

        $response->assertOk();
        $response->assertSee('id="body-input"', false);
        $response->assertSee('class="ck-host"', false);
        $response->assertSee('id="body-editor"', false);
        $response->assertDontSee('id="body-editor" hidden', false);
        $response->assertSee('js/ckeditor.js', false);
    }

    public function test_project_form_includes_case_study_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard.projects.create'));

        $response->assertOk();
        $response->assertSee('Case Study Details');
        $response->assertSee('name="client_name"', false);
        $response->assertSee('name="services"', false);
        $response->assertSee('name="tech_stack"', false);
        $response->assertSee('name="challenge"', false);
        $response->assertSee('name="solution"', false);
        $response->assertSee('name="results"', false);
        $response->assertSee('name="testimonial"', false);
        $response->assertSee('name="before_image"', false);
        $response->assertSee('name="after_image"', false);
    }

    public function test_project_case_study_fields_can_be_saved(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('dashboard.projects.store'), [
            'category' => 'development',
            'title' => 'Case Study Project',
            'meta' => 'A richer project write-up.',
            'body' => 'Project overview',
            'tags' => 'Laravel, SEO',
            'client_name' => 'Acme Studio',
            'project_year' => '2026',
            'services' => 'Web Design, Laravel',
            'tech_stack' => 'Laravel, Tailwind',
            'challenge' => 'The old site was hard to update.',
            'solution' => 'Built a cleaner project system.',
            'results' => 'The client can publish updates faster.',
            'testimonial' => 'Michael made the process simple.',
            'before_image' => '/storage/projects/before.jpg',
            'after_image' => '/storage/projects/after.jpg',
            'images' => '',
            'url' => 'https://example.com',
        ]);

        $response->assertRedirect(route('dashboard.projects.index'));

        $project = Project::where('title', 'Case Study Project')->firstOrFail();

        $this->assertSame('Acme Studio', $project->client_name);
        $this->assertSame(['Web Design', 'Laravel'], $project->services);
        $this->assertSame(['Laravel', 'Tailwind'], $project->tech_stack);
        $this->assertSame('/storage/projects/before.jpg', $project->before_image);
        $this->assertSame('/storage/projects/after.jpg', $project->after_image);
    }
}
