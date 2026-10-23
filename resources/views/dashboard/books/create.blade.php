@extends('dashboard.layouts.app')

@section('title', 'Add Book')
@section('page-title', 'Add Book')
@section('breadcrumb')
  <a href="{{ route('dashboard.books.index') }}">Books</a>
  <span class="dash-breadcrumb-sep">/</span> Add
@endsection

@section('content')

<div class="form-card" style="max-width:740px">
  <div class="form-section-label">New Book</div>

  <form method="POST" action="{{ route('dashboard.books.store') }}" enctype="multipart/form-data">
    @include('dashboard.books._form')

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Upload Book</button>
      <a href="{{ route('dashboard.books.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>

@endsection
