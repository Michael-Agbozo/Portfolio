<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * One-time content update that runs on the next deploy:
 * removes the phone screenshot from the Simply Perfect gallery, in case an
 * earlier deploy already added it. Every other gallery image is kept.
 */
return new class extends Migration
{
    private const PATH = '/storage/projects/simply-perfect-mobile.jpg';

    public function up(): void
    {
        $project = DB::table('projects')->where('slug', 'simply-perfect')->first();

        if ($project) {
            $gallery = json_decode($project->images ?? '[]', true) ?: [];
            $kept = array_values(array_filter($gallery, fn ($image) => $image !== self::PATH));

            if (count($kept) !== count($gallery)) {
                DB::table('projects')->where('id', $project->id)->update([
                    'images' => json_encode($kept),
                    'updated_at' => now(),
                ]);
            }
        }

        Storage::disk('public')->delete('projects/simply-perfect-mobile.jpg');
    }

    public function down(): void
    {
        // Content only — nothing to restore.
    }
};
