<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    /** Public flipbook reader. Hidden books are only visible to the logged-in owner. */
    public function show(Book $book)
    {
        abort_unless($book->active || auth()->check(), 404);

        return view('books.show', compact('book'));
    }
}
