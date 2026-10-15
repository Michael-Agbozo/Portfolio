<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * One-time content update that runs on the next deploy:
 * - Safe Hand Transport: adds the live link and a homepage screenshot.
 * - Simply Perfect: adds it as a new development project.
 *
 * Safe to run on any database — it never overwrites a link or image that
 * was already set in the dashboard, and never creates duplicates.
 */
return new class extends Migration
{
    public function up(): void
    {
        $safeHandImage = $this->publishImage('safe-hand-transport-site.jpg');
        $simplyPerfectImage = $this->publishImage('simply-perfect-site.jpg');

        $safeHand = DB::table('projects')->where('slug', 'safe-hand-transport')->first();

        if ($safeHand) {
            DB::table('projects')->where('id', $safeHand->id)->update(array_filter([
                'url' => $safeHand->url ? null : 'https://safehandtransport.net/',
                'feature_image' => $safeHand->feature_image ? null : $safeHandImage,
                'updated_at' => now(),
            ]));
        } else {
            $this->insertProject([
                'title' => 'Safe Hand Transport',
                'slug' => 'safe-hand-transport',
                'meta' => 'Full brand identity design and website development — safehandtransport.net',
                'tags' => ['Brand Identity', 'Web Development', 'Logo Design', 'WordPress'],
                'url' => 'https://safehandtransport.net/',
                'feature_image' => $safeHandImage,
                'body' => "Safe Hand Transport is a non-emergency medical transportation company serving Monmouth, Middlesex, Ocean, Somerset and Essex Counties in New Jersey.\n\n"
                    ."The project was a complete end-to-end engagement — brand identity design and website development delivered together, so the company launched with a cohesive, professional presence from day one.\n\n"
                    ."The website communicates the company's services clearly, builds trust instantly, supports English and Spanish, and makes it easy for visitors to book a ride.",
            ]);
        }

        if (! DB::table('projects')->where('slug', 'simply-perfect')->exists()) {
            $this->insertProject([
                'title' => 'Simply Perfect',
                'slug' => 'simply-perfect',
                'meta' => 'Event styling, rentals & online print shop — simplyperfect.be',
                'tags' => ['Web Development', 'E-commerce', 'Web Design'],
                'url' => 'https://www.simplyperfect.be/',
                'feature_image' => $simplyPerfectImage,
                'body' => "Simply Perfect is an event styling, rental and print business based in Bocholt, Belgium, serving clients across Belgium and the Netherlands.\n\n"
                    ."The website brings both sides of the business together: an elegant showcase for event decor — babyshowers, communions, backdrops and balloon styling — and a full online print shop where customers choose a product, set size, material and finishing, see their price instantly, upload their design and pay online.\n\n"
                    ."It also includes customer accounts, a first-order discount, Dutch and English versions, and an installable app experience.",
            ]);
        }
    }

    public function down(): void
    {
        // Content only — leave projects in place so nothing edited later is lost.
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

    private function insertProject(array $project): void
    {
        $highestNum = DB::table('projects')->pluck('num')->reduce(function (int $highest, ?string $num): int {
            return preg_match('/^\s*(\d+)/', (string) $num, $m) ? max($highest, (int) $m[1]) : $highest;
        }, 0);

        DB::table('projects')->insert([
            'num' => str_pad((string) ($highestNum + 1), 2, '0', STR_PAD_LEFT),
            'category' => 'development',
            'title' => $project['title'],
            'slug' => $project['slug'],
            'meta' => $project['meta'],
            'tags' => json_encode($project['tags']),
            'images' => json_encode(array_values(array_filter([$project['feature_image']]))),
            'url' => $project['url'],
            'feature_image' => $project['feature_image'],
            'body' => $project['body'],
            'active' => true,
            'sort_order' => (int) DB::table('projects')->max('sort_order') + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
