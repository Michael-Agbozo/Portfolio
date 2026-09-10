<?php

namespace App\Http\Controllers;

class MemorialBookController extends Controller
{
    private const DIRECTORY = 'memorial';
    private const FILENAME = 'dadaa-kate-dzidzornu-nyamadi-funeral-ebook.pdf';

    public function show()
    {
        $path = public_path(self::DIRECTORY.'/'.self::FILENAME);

        abort_unless(is_file($path), 404);

        $pagePaths = glob(public_path(self::DIRECTORY.'/pages/page-*.jpg')) ?: [];
        sort($pagePaths, SORT_NATURAL);

        $pages = array_map(
            fn (string $pagePath) => asset(self::DIRECTORY.'/pages/'.basename($pagePath)),
            $pagePaths
        );

        return view('memorial-book', [
            'bookUrl' => asset(self::DIRECTORY.'/'.self::FILENAME),
            'pages' => $pages,
        ]);
    }
}
