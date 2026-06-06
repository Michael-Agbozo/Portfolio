@extends('dashboard.layouts.app')

@section('title', 'Add Design')
@section('page-title', 'Add Design')
@section('breadcrumb')
  <a href="{{ route('dashboard.designs.index') }}">Designs</a>
  <span class="dash-breadcrumb-sep">/</span> Add
@endsection

@section('content')

<div class="form-card">
  <div class="form-section-label">Design Image</div>

  <form method="POST" action="{{ route('dashboard.designs.store') }}">
    @csrf

    <div class="form-group">
      <label class="f-label">Image URL *</label>
      <input class="f-input {{ $errors->has('src') ? 'is-error' : '' }}" type="url" name="src" id="src-input" value="{{ old('src') }}" placeholder="https://cdn.example.com/image.jpg" oninput="previewImg(this.value)"/>
      @error('src')<div class="field-error">{{ $message }}</div>@enderror
      <div class="f-hint">Paste a direct image URL (CDN, Webflow assets, etc.)</div>
    </div>

    <div id="img-preview" style="display:none;margin:.5rem 0 1rem">
      <img id="preview-img" src="" alt="Preview" style="max-width:200px;max-height:200px;object-fit:cover;border-radius:8px;border:1px solid var(--line)"/>
    </div>

    <div class="form-group">
      <label class="f-label">Alt Text *</label>
      <input class="f-input {{ $errors->has('alt') ? 'is-error' : '' }}" type="text" name="alt" value="{{ old('alt') }}" placeholder="Describe the image"/>
      @error('alt')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
      <label class="f-label">Sort Order</label>
      <input class="f-input" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" placeholder="0"/>
      <div class="f-hint">Lower number = appears first</div>
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Add to Gallery</button>
      <a href="{{ route('dashboard.designs.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>

@push('scripts')
<script>
function previewImg(url) {
  const wrap = document.getElementById('img-preview');
  const img = document.getElementById('preview-img');
  if (url.trim()) {
    img.src = url;
    wrap.style.display = 'block';
  } else {
    wrap.style.display = 'none';
  }
}
</script>
@endpush

@endsection
