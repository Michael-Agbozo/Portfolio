<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectNumberTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_projects_get_the_next_number_automatically(): void
    {
        Project::create([
            'num' => '09 — Featured',
            'category' => 'design',
            'title' => 'Existing Project',
            'slug' => 'existing-project',
            'meta' => 'Existing description',
            'tags' => [],
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('dashboard.projects.store'), [
            'num' => '99',
            'category' => 'development',
            'title' => 'New Project',
            'meta' => 'New description',
            'body' => '',
            'tags' => '',
            'images' => '',
            'url' => '',
        ]);

        $response->assertRedirect(route('dashboard.projects.index'));

        $this->assertDatabaseHas('projects', [
            'num' => '10',
            'title' => 'New Project',
        ]);
    }
}
