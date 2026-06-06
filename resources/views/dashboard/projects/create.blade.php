@extends('dashboard.layouts.app')

@section('title', 'Add Project')
@section('page-title', 'Add Project')
@section('breadcrumb')
  <a href="{{ route('dashboard.projects.index') }}">Projects</a>
  <span class="dash-breadcrumb-sep">/</span> Add
@endsection

@section('content')

<div class="form-card">
  <div class="form-section-label">Project Details</div>

  <form method="POST" action="{{ route('dashboard.projects.store') }}">
    @csrf

    <div class="form-grid-2">
      <div class="form-group">
        <label class="f-label">Label / Number *</label>
        <input class="f-input {{ $errors->has('num') ? 'is-error' : '' }}" type="text" name="num" value="{{ old('num') }}" placeholder="e.g. 01 — Featured"/>
        @error('num')<div class="field-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="f-label">Sort Order</label>
        <input class="f-input" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" placeholder="0"/>
      </div>
    </div>

    <div class="form-group">
      <label class="f-label">Title *</label>
      <input class="f-input {{ $errors->has('title') ? 'is-error' : '' }}" type="text" name="title" value="{{ old('title') }}" placeholder="Project name"/>
      @error('title')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
      <label class="f-label">Description</label>
      <input class="f-input" type="text" name="meta" value="{{ old('meta') }}" placeholder="Brief one-line description"/>
    </div>

    <div class="form-group">
      <label class="f-label">Tags</label>
      <input class="f-input" type="text" name="tags" value="{{ old('tags') }}" placeholder="Brand Identity, WordPress, Web Design"/>
      <div class="f-hint">Separate tags with commas</div>
    </div>

    <div class="form-group">
      <label class="f-label">URL</label>
      <input class="f-input {{ $errors->has('url') ? 'is-error' : '' }}" type="url" name="url" value="{{ old('url') }}" placeholder="https://example.com"/>
      @error('url')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Save Project</button>
      <a href="{{ route('dashboard.projects.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>

@endsection
