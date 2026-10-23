<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        $project = DB::table('projects')->where('slug', 'the-chronicles-conference')->first();

        if (! $project) {
            return;
        }

        $filename = 'the-chronicles-conference-events.jpg';
        $source = resource_path('project-images/'.$filename);
        if (! is_file($source)) {
            throw new RuntimeException('Missing Events screenshot.');
        }
        if (! Storage::disk('public')->exists('projects/'.$filename)) {
            Storage::disk('public')->put('projects/'.$filename, file_get_contents($source));
        }

        $ordered = array_map(
            fn ($page) => '/storage/projects/the-chronicles-conference-'.$page.'.jpg',
            ['home', 'about', 'events', 'contact']
        );
        $gallery = json_decode($project->images ?? '[]', true) ?: [];
        $extras = array_filter($gallery, fn ($image) => ! in_array($image, [
            '/storage/projects/the-chronicles-conference-site.jpg',
            '/storage/projects/the-chronicles-conference-mobile.jpg',
            ...$ordered,
        ], true));

        DB::table('projects')->where('id', $project->id)->update([
            'images' => json_encode(array_values(array_merge($ordered, $extras))),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Preserve the owner's current gallery.
    }
};
