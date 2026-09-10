<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemorialBookController extends Controller
{
    private const DIRECTORY = 'memorial';
    private const FILENAME = 'dadaa-kate-dzidzornu-nyamadi-funeral-ebook.pdf';

    public function show()
    {
        $path = public_path(self::DIRECTORY.'/'.self::FILENAME);
        $book = [
            'exists' => is_file($path),
            'url' => asset(self::DIRECTORY.'/'.self::FILENAME),
            'reader_url' => route('memorial.book'),
            'size' => is_file($path) ? filesize($path) : null,
            'updated_at' => is_file($path) ? filemtime($path) : null,
        ];

        return view('dashboard.memorial-book.show', compact('book'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'book' => 'required|file|mimes:pdf|max:102400',
        ]);

        $directory = public_path(self::DIRECTORY);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $request->file('book')->move($directory, self::FILENAME);
        $this->clearPageImages($directory.'/pages');

        return back()->with('success', 'Memorial book updated. The QR code link stays the same and now opens the new PDF.');
    }

    private function clearPageImages(string $pagesDirectory): void
    {
        if (!is_dir($pagesDirectory)) {
            return;
        }

        foreach (glob($pagesDirectory.'/page-*.jpg') ?: [] as $pageImage) {
            if (is_file($pageImage)) {
                unlink($pageImage);
            }
        }
    }
}
