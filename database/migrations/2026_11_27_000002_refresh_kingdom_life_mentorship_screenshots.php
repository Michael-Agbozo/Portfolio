<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

/**
 * Kingdom Life Mentorship changed its brand colour from brown to red, so
 * replace the published screenshots with the retaken ones. Only the image
 * files change; the project's details and gallery order stay as they are.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach (glob(resource_path('project-images/kingdom-life-mentorship-*.jpg')) as $source) {
            Storage::disk('public')->put('projects/'.basename($source), file_get_contents($source));
        }
    }

    public function down(): void
    {
        // The previous screenshots showed the old brand colour; nothing to restore.
    }
};
