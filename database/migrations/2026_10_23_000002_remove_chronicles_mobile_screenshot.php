<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $project = DB::table('projects')->where('slug', 'the-chronicles-conference')->first();

        if (! $project) {
            return;
        }

        $gallery = json_decode($project->images ?? '[]', true) ?: [];
        $kept = array_values(array_filter(
            $gallery,
            fn ($image) => $image !== '/storage/projects/the-chronicles-conference-mobile.jpg'
        ));

        if ($gallery !== $kept) {
            DB::table('projects')->where('id', $project->id)->update([
                'images' => json_encode($kept),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Preserve the gallery selected by the owner.
    }
};
