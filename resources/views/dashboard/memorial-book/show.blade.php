@extends('dashboard.layouts.app')

@section('title', 'Memorial Book')
@section('page-title', 'Memorial Book')
@section('breadcrumb')
  Memorial Book
@endsection

@section('content')

<div class="form-card">
  <div class="form-section-label">Funeral book PDF</div>

  @if($book['exists'])
    <p style="color:var(--muted);font-size:.85rem;margin-bottom:1rem">
      The public reader is available at
      <a href="{{ $book['reader_url'] }}" target="_blank" rel="noopener" style="color:var(--orange)">/dadaa-kate-dzidzornu-nyamadi-funeral-ebook</a>.
    </p>
    <p class="f-hint" style="margin-bottom:1.25rem">
      Last updated {{ date('M j, Y g:ia', $book['updated_at']) }} - {{ round($book['size'] / 1048576, 2) }} MB
    </p>
  @else
    <p style="color:var(--muted);font-size:.85rem;margin-bottom:1.25rem">
      Upload the funeral book PDF here. After that, use
      <a href="{{ $book['reader_url'] }}" target="_blank" rel="noopener" style="color:var(--orange)">/dadaa-kate-dzidzornu-nyamadi-funeral-ebook</a>
      for your QR code.
    </p>
  @endif

  <form method="POST" action="{{ route('dashboard.memorial-book.update') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label class="f-label">Upload funeral book</label>
      <input class="f-input @error('book') is-error @enderror" type="file" name="book" accept="application/pdf,.pdf" required style="padding:.5rem .9rem;cursor:pointer"/>
      @error('book')<div class="field-error">{{ $message }}</div>@enderror
      <div class="f-hint">PDF only. Max 100 MB. Uploading replaces the current funeral book.</div>
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Upload Book</button>
      @if($book['exists'])
        <a class="btn btn-secondary" href="{{ $book['reader_url'] }}" target="_blank" rel="noopener">Open reader</a>
        <a class="btn btn-secondary" href="{{ $book['url'] }}" target="_blank" rel="noopener">View PDF</a>
      @endif
    </div>
  </form>
</div>

@endsection
