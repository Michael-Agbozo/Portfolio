@extends('dashboard.layouts.app')

@section('title', 'Edit Book')
@section('page-title', 'Edit Book')
@section('breadcrumb')
  <a href="{{ route('dashboard.books.index') }}">Books</a>
  <span class="dash-breadcrumb-sep">/</span> {{ $book->title }}
@endsection

@section('content')

<div class="form-card" style="max-width:740px;margin-bottom:1.5rem">
  <div class="form-section-label">QR Code</div>

  <div style="display:flex;gap:1.5rem;align-items:center;flex-wrap:wrap">
    <img src="{{ route('dashboard.books.qr', [$book, 'svg']) }}" alt="QR code for {{ $book->title }}" width="180" height="180"
      style="display:block;background:#fff;border-radius:8px;padding:6px"/>
    <div>
      <p style="color:var(--muted);font-size:.85rem;margin-bottom:.4rem">Scanning this opens</p>
      <a href="{{ $book->readerUrl() }}" target="_blank" rel="noopener" style="color:var(--orange);font-size:.85rem;word-break:break-all">{{ $book->readerUrl() }}</a>
      @unless($book->active)
        <p class="f-hint" style="margin-top:.5rem">This book is hidden, so visitors who scan it will see "not found" until you mark it active.</p>
      @endunless
      <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-top:1rem">
        <a href="{{ route('dashboard.books.qr', [$book, 'png']) }}?download=1" class="btn btn-primary btn-sm">↓ Download PNG</a>
        <a href="{{ route('dashboard.books.qr', [$book, 'svg']) }}?download=1" class="btn btn-secondary btn-sm">↓ Download SVG</a>
        <a href="{{ $book->readerUrl() }}" target="_blank" rel="noopener" class="btn btn-ghost btn-sm">Open book</a>
      </div>
      <p class="f-hint" style="margin-top:.6rem">PNG for WhatsApp, Word or printing. SVG for designers; it stays sharp at any size.</p>
    </div>
  </div>
</div>

<div class="form-card" style="max-width:740px">
  <div class="form-section-label">Details</div>

  @php($size = $book->pdfSize())
  <p class="f-hint" style="margin-bottom:1.25rem">
    @if($size)
      Current PDF: {{ round($size / 1048576, 2) }} MB, updated {{ $book->updated_at->format('M j, Y g:ia') }}.
      <a href="{{ $book->pdfUrl() }}" target="_blank" rel="noopener" style="color:var(--orange)">View PDF</a>
    @else
      The PDF file is missing. Upload it again below.
    @endif
  </p>

  <form id="book-edit-form" method="POST" action="{{ route('dashboard.books.update', $book) }}" enctype="multipart/form-data">
    @method('PUT')
    @include('dashboard.books._form')
  </form>

  <div class="form-actions">
    <button class="btn btn-primary" type="submit" form="book-edit-form">Save Changes</button>
    <a href="{{ route('dashboard.books.index') }}" class="btn btn-secondary">Back</a>
    <form method="POST" action="{{ route('dashboard.books.destroy', $book) }}"
      onsubmit="return confirmDelete(event, this, 'This book and its PDF will be permanently removed, and its QR code will stop working.', 'Delete this book?')" style="margin-left:auto">
      @csrf @method('DELETE')
      <button class="btn btn-danger" type="submit">Delete</button>
    </form>
  </div>
</div>

@endsection
