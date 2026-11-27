<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    private const PROJECTS = [
        [
            'slug' => 'kingdom-life-mentorship',
            'title' => 'Kingdom Life Mentorship',
            'url' => 'https://kingdomlifementorship.com/',
            'meta' => 'Bilingual mentorship website with session registration, masterclasses, and an online shop.',
            'tags' => ['Web Design', 'Web Development', 'E-commerce'],
            'tech_stack' => ['WordPress', 'Elementor', 'WooCommerce', 'TranslatePress'],
            'body' => 'Kingdom Life Mentorship has guided ministries, businesses, and individuals since 2018. The website presents the yearly mentorship programme and masterclasses, lets visitors register for upcoming sessions, sells study materials through an online shop, and shares testimonials from past mentees, in both English and Dutch.',
            'pages' => ['home', 'about', 'mentorship', 'session', 'masterclass', 'masterclass-detail', 'shop', 'product', 'cart', 'checkout', 'testimonials', 'account', 'contact'],
        ],
        [
            'slug' => 'kingdom-arts-academy',
            'title' => 'Kingdom Arts Academy',
            'url' => 'https://thekingdomartsacademy.com/',
            'meta' => 'Bilingual website for a dance ministry school with classes, events, and online enrolment.',
            'tags' => ['Web Design', 'Web Development', 'Education'],
            'tech_stack' => ['WordPress', 'Elementor'],
            'body' => 'Kingdom Arts Academy trains dancers in praise, worship, prophetic, and apostolic dance ministry in the Netherlands and Belgium. The website introduces the academy and its history, explains each class, lists upcoming and past events, and lets new students enrol online, in both English and Dutch.',
            'pages' => ['home', 'about', 'classes', 'events', 'enrolment', 'class-registration', 'register', 'contact'],
        ],
    ];

    public function up(): void
    {
        foreach (self::PROJECTS as $project) {
            $feature = $this->publish($project['slug'].'-site.jpg');
            $images = array_map(fn ($page) => $this->publish($project['slug'].'-'.$page.'.jpg'), $project['pages']);

            $existing = DB::table('projects')->where('slug', $project['slug'])
                ->orWhere('url', $project['url'])
                ->orWhere('url', rtrim($project['url'], '/'))->first();

            if ($existing) {
                $gallery = json_decode($existing->images ?? '[]', true) ?: [];
                DB::table('projects')->where('id', $existing->id)->update([
                    'images' => json_encode(array_values(array_unique(array_merge($gallery, $images)))),
                    'feature_image' => $existing->feature_image ?: $feature,
                    'updated_at' => now(),
                ]);

                continue;
            }

            $highest = DB::table('projects')->pluck('num')->reduce(function (int $highest, ?string $num): int {
                return preg_match('/^\s*(\d+)/', (string) $num, $matches)
                    ? max($highest, (int) $matches[1]) : $highest;
            }, 0);

            DB::table('projects')->insert([
                'num' => str_pad((string) ($highest + 1), 2, '0', STR_PAD_LEFT),
                'category' => 'development',
                'title' => $project['title'],
                'slug' => $project['slug'],
                'meta' => $project['meta'],
                'client_name' => $project['title'],
                'services' => json_encode(['Web Design', 'Web Development']),
                'tech_stack' => json_encode($project['tech_stack']),
                'tags' => json_encode($project['tags']),
                'url' => $project['url'],
                'feature_image' => $feature,
                'images' => json_encode($images),
                'body' => $project['body'],
                'active' => true,
                'sort_order' => (int) DB::table('projects')->max('sort_order') + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Keep portfolio content and later dashboard edits when rolling back.
    }

    /** Copy a bundled screenshot into public storage and return its URL. */
    private function publish(string $filename): string
    {
        $source = resource_path('project-images/'.$filename);

        if (! is_file($source)) {
            throw new RuntimeException('Missing project screenshot: '.$filename);
        }

        $path = 'projects/'.$filename;
        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->put($path, file_get_contents($source));
        }

        return '/storage/'.$path;
    }
};
