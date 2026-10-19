<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * One-time content update that runs on the next deploy:
 * adds more website screenshots to the Simply Perfect project gallery.
 *
 * Safe to run on any database — it only appends screenshots that are not
 * already in the gallery, keeps every image set in the dashboard, and does
 * nothing if the project does not exist.
 */
return new class extends Migration
{
    private const SCREENSHOTS = [
        'simply-perfect-about.jpg',
        'simply-perfect-print-shop.jpg',
        'simply-perfect-product.jpg',
        'simply-perfect-cutline.jpg',
        'simply-perfect-contact.jpg',
    ];

    public function up(): void
    {
        $project = DB::table('projects')->where('slug', 'simply-perfect')->first();

        if (! $project) {
            return;
        }

        $gallery = json_decode($project->images ?? '[]', true) ?: [];

        foreach (self::SCREENSHOTS as $filename) {
            $path = $this->publishImage($filename);

            if ($path && ! in_array($path, $gallery, true)) {
                $gallery[] = $path;
            }
        }

        DB::table('projects')->where('id', $project->id)->update([
            'images' => json_encode(array_values($gallery)),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Content only — leave the gallery in place so nothing edited later is lost.
    }

    /**
     * Copy a bundled screenshot into public storage so it behaves exactly
     * like an image uploaded through the dashboard.
     */
    private function publishImage(string $filename): ?string
    {
        $source = resource_path('project-images/'.$filename);

        if (! is_file($source)) {
            return null;
        }

        Storage::disk('public')->put('projects/'.$filename, file_get_contents($source));

        return '/storage/projects/'.$filename;
    }
};
