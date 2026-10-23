<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * One-time content update that runs on the next deploy:
 * moves the two hand-made ebooks into the new Books section, keeping their
 * slugs so the QR codes already printed for them keep working.
 *
 * A book is only added when its PDF is present and it isn't in the table yet.
 */
return new class extends Migration
{
    private const BOOKS = [
        [
            'title' => 'IET-GH Induction Of New Members',
            'slug' => 'iet-gh-induction-of-new-members',
            'description' => 'IET-GH induction of new members ebook.',
            'source' => 'ebooks/iet-gh-induction-of-new-members/iet-gh-induction-of-new-members.pdf',
        ],
        [
            'title' => 'Dadaa Kate Dzidzornu Nyamadi Funeral Ebook',
            'slug' => 'dadaa-kate-dzidzornu-nyamadi-funeral-ebook',
            'description' => 'Dadaa Kate Dzidzornu Nyamadi funeral ebook shared with family and friends.',
            'source' => 'memorial/dadaa-kate-dzidzornu-nyamadi-funeral-ebook.pdf',
        ],
    ];

    public function up(): void
    {
        foreach (self::BOOKS as $book) {
            $source = public_path($book['source']);

            if (! is_file($source) || DB::table('books')->where('slug', $book['slug'])->exists()) {
                continue;
            }

            $path = 'books/'.$book['slug'].'.pdf';
            Storage::disk('public')->put($path, file_get_contents($source));

            DB::table('books')->insert([
                'title' => $book['title'],
                'slug' => $book['slug'],
                'description' => $book['description'],
                'pdf_path' => $path,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Content only — leave the books in place so nothing edited later is lost.
    }
};
