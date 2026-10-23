<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->withoutVite();
    }

    public function test_guests_cannot_open_the_books_dashboard(): void
    {
        $this->get(route('dashboard.books.index'))->assertRedirect(route('login'));
    }

    public function test_admin_can_open_the_books_pages(): void
    {
        $book = $this->makeBook();
        $this->actingAs(User::factory()->create());

        $this->get(route('dashboard.books.index'))
            ->assertOk()
            ->assertSee('Memories')
            ->assertSee('/books/memories', false);
        $this->get(route('dashboard.books.create'))->assertOk()->assertSee('Upload Book');
        $this->get(route('dashboard.books.edit', $book))
            ->assertOk()
            ->assertSee('Download PNG')
            ->assertSee('Download SVG');
    }

    public function test_admin_can_upload_a_book(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('dashboard.books.store'), [
                'title' => 'Family Memories 2026',
                'pdf' => UploadedFile::fake()->create('memories.pdf', 200, 'application/pdf'),
            ])
            ->assertSessionHas('success');

        $book = Book::where('title', 'Family Memories 2026')->firstOrFail();

        $this->assertSame('family-memories-2026', $book->slug);
        $this->assertTrue($book->active);
        Storage::disk('public')->assertExists($book->pdf_path);
    }

    public function test_slugs_must_be_unique(): void
    {
        $this->makeBook(['slug' => 'taken']);

        $this->actingAs(User::factory()->create())
            ->post(route('dashboard.books.store'), [
                'title' => 'Another',
                'slug' => 'taken',
                'pdf' => UploadedFile::fake()->create('a.pdf', 10, 'application/pdf'),
            ])
            ->assertSessionHasErrors('slug');
    }

    public function test_only_pdfs_are_accepted(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('dashboard.books.store'), [
                'title' => 'Not a PDF',
                'pdf' => UploadedFile::fake()->image('photo.jpg'),
            ])
            ->assertSessionHasErrors('pdf');
    }

    public function test_replacing_the_pdf_keeps_the_link_and_removes_the_old_file(): void
    {
        $book = $this->makeBook();
        $oldPath = $book->pdf_path;

        $this->actingAs(User::factory()->create())
            ->put(route('dashboard.books.update', $book), [
                'title' => $book->title,
                'slug' => $book->slug,
                'pdf' => UploadedFile::fake()->create('new.pdf', 50, 'application/pdf'),
            ])
            ->assertSessionHas('success');

        $book->refresh();
        $this->assertSame('memories', $book->slug);
        $this->assertNotSame($oldPath, $book->pdf_path);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($book->pdf_path);
    }

    public function test_public_reader_shows_the_flipbook(): void
    {
        $book = $this->makeBook();

        $this->get('/books/memories')
            ->assertOk()
            ->assertSee('Memories')
            ->assertSee($book->pdfUrl(), false)
            ->assertSee('data-book', false)
            ->assertSee('data-flip-sheet', false)
            ->assertSee('corner-turn', false);
    }

    public function test_hidden_books_are_not_public(): void
    {
        $this->makeBook(['active' => false]);

        $this->get('/books/memories')->assertNotFound();
        $this->actingAs(User::factory()->create())->get('/books/memories')->assertOk();
    }

    public function test_old_printed_links_redirect_to_the_new_reader(): void
    {
        $this->get('/dadaa-kate-dzidzornu-nyamadi-funeral-ebook')
            ->assertRedirect('/books/dadaa-kate-dzidzornu-nyamadi-funeral-ebook');
        $this->get('/iet-gh-induction-of-new-members')
            ->assertRedirect('/books/iet-gh-induction-of-new-members');
    }

    public function test_admin_can_download_the_qr_code(): void
    {
        $book = $this->makeBook();
        $this->actingAs(User::factory()->create());

        $png = $this->get(route('dashboard.books.qr', [$book, 'png']).'?download=1')
            ->assertOk()
            ->assertHeader('Content-Type', 'image/png')
            ->assertHeader('Content-Disposition', 'attachment; filename="memories-qr.png"');
        $this->assertStringStartsWith("\x89PNG", $png->getContent());

        $this->get(route('dashboard.books.qr', [$book, 'svg']))
            ->assertOk()
            ->assertHeader('Content-Type', 'image/svg+xml');

        $this->get(route('dashboard.books.qr', [$book, 'gif']))->assertNotFound();
    }

    public function test_guests_cannot_download_qr_codes(): void
    {
        $book = $this->makeBook();

        $this->get(route('dashboard.books.qr', [$book, 'png']))->assertRedirect(route('login'));
    }

    public function test_deleting_a_book_removes_its_pdf(): void
    {
        $book = $this->makeBook();

        $this->actingAs(User::factory()->create())
            ->delete(route('dashboard.books.destroy', $book))
            ->assertRedirect(route('dashboard.books.index'));

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
        Storage::disk('public')->assertMissing($book->pdf_path);
    }

    private function makeBook(array $attributes = []): Book
    {
        Storage::disk('public')->put('books/memories.pdf', '%PDF-1.4');

        return Book::create(array_merge([
            'title' => 'Memories',
            'slug' => 'memories',
            'pdf_path' => 'books/memories.pdf',
            'active' => true,
        ], $attributes));
    }
}
