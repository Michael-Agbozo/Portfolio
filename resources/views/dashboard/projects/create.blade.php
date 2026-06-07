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
        <label class="f-label">Category *</label>
        <select class="f-select" name="category">
          <option value="design"       {{ old('category', 'design') === 'design'      ? 'selected' : '' }}>Design & Branding</option>
          <option value="development"  {{ old('category') === 'development'            ? 'selected' : '' }}>Development</option>
        </select>
      </div>
    </div>

    <div class="form-grid-2">
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
      <label class="f-label">Full Description</label>
      <textarea class="f-textarea" name="body" placeholder="Write a detailed description of this project — what it involved, what you built, challenges, outcomes…" style="min-height:200px">{{ old('body') }}</textarea>
      <div class="f-hint">This appears on the project's detail page when someone clicks to read more</div>
    </div>

    <div class="form-group">
      <label class="f-label">Tags</label>
      <input class="f-input" type="text" name="tags" value="{{ old('tags') }}" placeholder="Brand Identity, WordPress, Web Design"/>
      <div class="f-hint">Separate tags with commas</div>
    </div>

    <div class="form-group">
      <label class="f-label">Project Images</label>
      <textarea class="f-textarea" name="images" placeholder="/storage/projects/my-image.jpg&#10;/storage/projects/another.jpg" style="min-height:100px">{{ old('images') }}</textarea>
      <div class="f-hint">One image path per line. These show as a gallery on the project detail page.</div>
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
