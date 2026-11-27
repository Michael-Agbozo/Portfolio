<?php

namespace Tests\Feature;

use App\Models\Design;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DesignEditorTest extends TestCase
{
    use RefreshDatabase;

    public function test_saving_the_design_edit_form_updates_the_design(): void
    {
        $user = User::factory()->create();
        $design = Design::create(['src' => '/storage/designs/old.jpg', 'alt' => 'Old caption']);

        // The edit form posts with _method=PUT, so the route must accept PUT.
        $this->actingAs($user)
            ->get(route('dashboard.designs.edit', $design))
            ->assertSee('name="_method" value="PUT"', false);

        $this->actingAs($user)
            ->put(route('dashboard.designs.update', $design), [
                'src' => 'https://example.com/new.jpg',
                'alt' => 'New caption',
            ])
            ->assertRedirect(route('dashboard.designs.index'));

        $this->assertSame('New caption', $design->fresh()->alt);
        $this->assertSame('https://example.com/new.jpg', $design->fresh()->src);
    }
}
