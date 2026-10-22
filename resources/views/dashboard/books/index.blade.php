@extends('dashboard.layouts.app')

@section('title', 'Books')
@section('page-title', 'Books')
@section('breadcrumb') Books @endsection

@section('header-actions')
  <a href="{{ route('dashboard.books.create') }}" class="btn btn-primary btn-sm">+ Add Book</a>
@endsection

@section('content')

<div class="table-wrap">
  <div class="table-head">
    <div class="table-title">All Books <span style="font-size:.72rem;font-weight:400;color:var(--dim)">({{ $books->count() }})</span></div>
  </div>

  @if($books->isEmpty())
    <div class="empty-state">
      <div class="empty-icon">▤</div>
      <div class="empty-title">No books yet</div>
      <p style="margin-top:.5rem">
        <a href="{{ route('dashboard.books.create') }}" class="btn btn-primary btn-sm" style="margin-top:.75rem">Upload your first PDF</a>
      </p>
    </div>
  @else
    <table>
      <thead>
        <tr>
          <th>QR</th>
          <th>Title</th>
          <th>Link</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($books as $book)
        <tr>
          <td data-label="QR">
            <img src="{{ route('dashboard.books.qr', [$book, 'svg']) }}" alt="QR code for {{ $book->title }}" width="64" height="64" loading="lazy" style="display:block;background:#fff;border-radius:6px;padding:3px"/>
          </td>
          <td data-label="Title" class="td-main">{{ $book->title }}</td>
          <td data-label="Link">
            <a href="{{ $book->readerUrl() }}" target="_blank" rel="noopener" style="color:var(--orange);font-size:.75rem">/books/{{ $book->slug }}</a>
          </td>
          <td data-label="Status">
            <form method="POST" action="{{ route('dashboard.books.toggle-active', $book) }}">
              @csrf @method('PATCH')
              <button type="submit" class="status-toggle {{ $book->active ? 'is-active' : 'is-inactive' }}" title="Click to mark {{ $book->active ? 'inactive' : 'active' }}">
                <span class="dot"></span> {{ $book->active ? 'Active' : 'Inactive' }}
              </button>
            </form>
          </td>
          <td data-label="">
            <div style="display:flex;gap:.4rem;flex-wrap:wrap;justify-content:flex-end">
              <a href="{{ route('dashboard.books.qr', [$book, 'png']) }}?download=1" class="btn btn-primary btn-sm">↓ QR</a>
              <a href="{{ $book->readerUrl() }}" target="_blank" rel="noopener" class="btn btn-ghost btn-sm">Open</a>
              <a href="{{ route('dashboard.books.edit', $book) }}" class="btn btn-secondary btn-sm">Edit</a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>

@endsection
