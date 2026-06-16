<?php

namespace Tests\Feature;

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
        $response->assertSee('id="body-editor" class="ck-host"', false);
        $response->assertDontSee('id="body-editor" class="ck-host" hidden', false);
        $response->assertSee('js/ckeditor.js', false);
    }
}
