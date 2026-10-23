<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        $images = [];
        foreach (['site', 'home', 'about', 'contact', 'mobile'] as $view) {
            $filename = 'the-chronicles-conference-'.$view.'.jpg';
            $source = resource_path('project-images/'.$filename);

            if (! is_file($source)) {
                throw new RuntimeException('Missing conference screenshot: '.$filename);
            }

            $path = 'projects/'.$filename;
            if (! Storage::disk('public')->exists($path)) {
                Storage::disk('public')->put($path, file_get_contents($source));
            }
            $images[] = '/storage/'.$path;
        }

        $existing = DB::table('projects')->where('slug', 'the-chronicles-conference')
            ->orWhere('url', 'https://thechroniclesconference.com/')
            ->orWhere('url', 'https://thechroniclesconference.com')->first();

        if ($existing) {
            $gallery = json_decode($existing->images ?? '[]', true) ?: [];
            DB::table('projects')->where('id', $existing->id)->update([
                'images' => json_encode(array_values(array_unique(array_merge($gallery, $images)))),
                'feature_image' => $existing->feature_image ?: $images[0],
                'updated_at' => now(),
            ]);

            return;
        }

        $highest = DB::table('projects')->pluck('num')->reduce(function (int $highest, ?string $num): int {
            return preg_match('/^\s*(\d+)/', (string) $num, $matches)
                ? max($highest, (int) $matches[1]) : $highest;
        }, 0);

        DB::table('projects')->insert([
            'num' => str_pad((string) ($highest + 1), 2, '0', STR_PAD_LEFT),
            'category' => 'development',
            'title' => 'The Chronicles Conference',
            'slug' => 'the-chronicles-conference',
            'meta' => 'Conference website with event registration, international event information, and photo galleries.',
            'client_name' => 'The Chronicles Conference',
            'services' => json_encode(['Web Design', 'Web Development']),
            'tags' => json_encode(['Web Design', 'Web Development', 'Events']),
            'url' => 'https://thechroniclesconference.com/',
            'feature_image' => $images[0],
            'images' => json_encode($images),
            'body' => 'The Chronicles Conference brings people together for faith-based events focused on spiritual growth, purpose, and empowerment. The website presents conference information for Holland, Ghana, and Zambia, connects visitors to registration, and shares photographs from past events.',
            'active' => true,
            'sort_order' => (int) DB::table('projects')->max('sort_order') + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Keep portfolio content and later dashboard edits when rolling back.
    }
};
