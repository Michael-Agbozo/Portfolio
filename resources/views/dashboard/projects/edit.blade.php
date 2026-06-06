@extends('dashboard.layouts.app')

@section('title', 'Edit Project')
@section('page-title', 'Edit Project')
@section('breadcrumb')
  <a href="{{ route('dashboard.projects.index') }}">Projects</a>
  <span class="dash-breadcrumb-sep">/</span> {{ $project->title }}
@endsection

@section('content')

<div class="form-card">
  <div class="form-section-label">Edit Project Details</div>

  <form method="POST" action="{{ route('dashboard.projects.update', $project) }}">
    @csrf @method('PUT')

    <div class="form-grid-2">
      <div class="form-group">
        <label class="f-label">Label / Number *</label>
        <input class="f-input {{ $errors->has('num') ? 'is-error' : '' }}" type="text" name="num" value="{{ old('num', $project->num) }}" placeholder="e.g. 01 — Featured"/>
        @error('num')<div class="field-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="f-label">Sort Order</label>
        <input class="f-input" type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order) }}" placeholder="0"/>
      </div>
    </div>

    <div class="form-group">
      <label class="f-label">Title *</label>
      <input class="f-input {{ $errors->has('title') ? 'is-error' : '' }}" type="text" name="title" value="{{ old('title', $project->title) }}" placeholder="Project name"/>
      @error('title')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
      <label class="f-label">Description</label>
      <input class="f-input" type="text" name="meta" value="{{ old('meta', $project->meta) }}" placeholder="Brief one-line description"/>
    </div>

    <div class="form-group">
      <label class="f-label">Tags</label>
      <input class="f-input" type="text" name="tags" value="{{ old('tags', implode(', ', $project->tags ?? [])) }}" placeholder="Brand Identity, WordPress"/>
      <div class="f-hint">Separate tags with commas</div>
    </div>

    <div class="form-group">
      <label class="f-label">URL</label>
      <input class="f-input {{ $errors->has('url') ? 'is-error' : '' }}" type="url" name="url" value="{{ old('url', $project->url) }}" placeholder="https://example.com"/>
      @error('url')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Update Project</button>
      <a href="{{ route('dashboard.projects.index') }}" class="btn btn-secondary">Cancel</a>
      <form method="POST" action="{{ route('dashboard.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')" style="margin-left:auto">
        @csrf @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete Project</button>
      </form>
    </div>
  </form>
</div>

@endsection
