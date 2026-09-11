<?php

namespace App\Http\Controllers;

class MemorialBookController extends Controller
{
    private const BOOKS = [
        'memorial' => [
            'directory' => 'memorial',
            'filename' => 'dadaa-kate-dzidzornu-nyamadi-funeral-ebook.pdf',
            'title' => 'Dadaa Kate Dzidzornu Nyamadi Funeral Ebook',
            'description' => 'Dadaa Kate Dzidzornu Nyamadi funeral ebook shared with family and friends.',
            'route' => 'memorial.book',
        ],
        'iet-induction' => [
            'directory' => 'ebooks/iet-gh-induction-of-new-members',
            'filename' => 'iet-gh-induction-of-new-members.pdf',
            'title' => 'IET-GH Induction Of New Members',
            'description' => 'IET-GH induction of new members ebook.',
            'route' => 'iet.induction.book',
        ],
    ];

    public function show()
    {
        return $this->renderBook(self::BOOKS['memorial']);
    }

    public function showIetInduction()
    {
        return $this->renderBook(self::BOOKS['iet-induction']);
    }

    private function renderBook(array $book)
    {
        $path = public_path($book['directory'].'/'.$book['filename']);

        abort_unless(is_file($path), 404);

        $pagePaths = glob(public_path($book['directory'].'/pages/page-*.jpg')) ?: [];
        sort($pagePaths, SORT_NATURAL);

        $pages = array_map(
            fn (string $pagePath) => asset($book['directory'].'/pages/'.basename($pagePath)),
            $pagePaths
        );

        return view('memorial-book', [
            'bookUrl' => asset($book['directory'].'/'.$book['filename']),
            'canonicalUrl' => route($book['route']),
            'description' => $book['description'],
            'pages' => $pages,
            'title' => $book['title'],
        ]);
    }
}
