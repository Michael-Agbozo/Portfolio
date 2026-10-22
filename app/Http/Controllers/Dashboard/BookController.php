<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Support\BookQrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('id', 'desc')->get();

        return view('dashboard.books.index', compact('books'));
    }

    public function create()
    {
        return view('dashboard.books.create', ['book' => new Book]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, null);
        $data['pdf_path'] = $request->file('pdf')->store('books', 'public');

        $book = Book::create($data);

        return redirect()->route('dashboard.books.edit', $book)->with('success', 'Book added. Download its QR code below.');
    }

    public function edit(Book $book)
    {
        return view('dashboard.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $this->validated($request, $book);

        if ($request->hasFile('pdf')) {
            Storage::disk('public')->delete($book->pdf_path);
            $data['pdf_path'] = $request->file('pdf')->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('dashboard.books.edit', $book)->with('success', 'Book updated.');
    }

    public function toggleActive(Book $book)
    {
        $book->update(['active' => ! $book->active]);

        return back()->with('success', $book->active ? 'Book is now public.' : 'Book is now hidden.');
    }

    public function destroy(Book $book)
    {
        Storage::disk('public')->delete($book->pdf_path);
        $book->delete();

        return redirect()->route('dashboard.books.index')->with('success', 'Book removed.');
    }

    /** QR code image; ?download=1 saves it as a file instead of showing it. */
    public function qr(Request $request, Book $book, string $format)
    {
        abort_unless(in_array($format, BookQrCode::FORMATS, true), 404);

        $response = response(BookQrCode::make($book, $format))
            ->header('Content-Type', BookQrCode::mimeType($format));

        if ($request->boolean('download')) {
            $response->header('Content-Disposition', 'attachment; filename="'.$book->slug.'-qr.'.$format.'"');
        }

        return $response;
    }

    private function validated(Request $request, ?Book $book): array
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('title', ''))]);

        $data = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => ['required', 'string', 'max:120', 'alpha_dash', Rule::unique('books', 'slug')->ignore($book)],
            'description' => 'nullable|string|max:500',
            'pdf' => [$book ? 'nullable' : 'required', 'file', 'mimes:pdf', 'max:102400'],
        ], [
            'slug.unique' => 'Another book already uses this link.',
        ]);

        unset($data['pdf']);

        return $data;
    }
}
