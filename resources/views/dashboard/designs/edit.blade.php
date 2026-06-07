@extends('dashboard.layouts.app')

@section('title', 'Edit Design')
@section('page-title', 'Edit Design')
@section('breadcrumb')
  <a href="{{ route('dashboard.designs.index') }}">Designs</a>
  <span class="dash-breadcrumb-sep">/</span>
  <a href="{{ route('dashboard.designs.show', $design) }}">{{ $design->alt ?: 'Design #' . $design->id }}</a>
  <span class="dash-breadcrumb-sep">/</span> Edit
@endsection

@section('content')

<div class="form-card" style="max-width:740px">
  <div class="form-section-label">Edit Design</div>

  <form id="design-edit-form" method="POST" action="{{ route('dashboard.designs.update', $design) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Current image preview --}}
    <div style="margin-bottom:1.5rem">
      <div class="f-label" style="margin-bottom:.6rem">Current Image</div>
      <div style="position:relative;display:inline-block">
        <img id="current-img" src="{{ $design->src }}" alt="{{ $design->alt }}"
          style="max-width:100%;max-height:260px;object-fit:contain;border-radius:8px;border:1px solid var(--line);background:var(--bg3);display:block"/>
      </div>
    </div>

    {{-- File upload --}}
    <div class="form-group">
      <label class="f-label">Replace with a new image</label>
      <div style="display:flex;gap:.6rem;flex-wrap:wrap;align-items:center">
        <label class="btn btn-secondary btn-sm" style="cursor:pointer">
          ↑ Upload Image
          <input type="file" name="image" id="file-input" accept="image/*" onchange="previewFile(this)" style="display:none"/>
        </label>
        <button type="button" class="btn btn-secondary btn-sm" onclick="openMediaPicker('design')">◈ Choose from Library</button>
      </div>
      @error('image')<div class="field-error">{{ $message }}</div>@enderror
      <div class="f-hint">JPG, PNG, WEBP — max 50 MB. Leave blank to keep the current image.</div>
    </div>

    {{-- New preview appears when file is chosen --}}
    <div id="new-preview" style="display:none;margin-bottom:1rem">
      <div class="f-label" style="margin-bottom:.5rem">New Image Preview</div>
      <img id="preview-img" src="" alt="Preview"
        style="max-width:100%;max-height:200px;object-fit:contain;border-radius:8px;border:1px solid var(--orange);background:var(--bg3);display:block"/>
    </div>

    {{-- Or paste a URL --}}
    <div class="form-group">
      <label class="f-label">— or replace with an image URL</label>
      <input class="f-input {{ $errors->has('src') ? 'is-error' : '' }}" type="text" name="src"
        value="{{ old('src') }}" placeholder="https://cdn.example.com/image.jpg" id="url-input" oninput="previewUrl(this.value)"/>
      @error('src')<div class="field-error">{{ $message }}</div>@enderror
      <div class="f-hint">Paste a direct image URL. Leave blank to keep the current image.</div>
    </div>

    {{-- Alt text --}}
    <div class="form-group">
      <label class="f-label">Alt Text *</label>
      <input class="f-input {{ $errors->has('alt') ? 'is-error' : '' }}" type="text" name="alt"
        value="{{ old('alt', $design->alt) }}" placeholder="Describe the image"/>
      @error('alt')<div class="field-error">{{ $message }}</div>@enderror
    </div>

  </form>

  <div class="form-actions">
    <button class="btn btn-primary" type="submit" form="design-edit-form">Save Changes</button>
    <a href="{{ route('dashboard.designs.show', $design) }}" class="btn btn-secondary">Cancel</a>
    <form method="POST" action="{{ route('dashboard.designs.destroy', $design) }}"
      onsubmit="return confirmDelete(event, this, 'This design and its image will be permanently removed.', 'Delete this design?')" style="margin-left:auto">
      @csrf @method('DELETE')
      <button class="btn btn-danger" type="submit">Delete</button>
    </form>
  </div>
</div>

@include('dashboard.partials._media-picker')

@push('scripts')
<script>
function previewFile(input) {
  const file = input.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = e => {
    document.getElementById('preview-img').src = e.target.result;
    document.getElementById('new-preview').style.display = 'block';
    document.getElementById('url-input').value = '';
  };
  reader.readAsDataURL(file);
}

function previewUrl(url) {
  if (!url.trim()) return;
  document.getElementById('current-img').src = url;
  document.getElementById('file-input').value = '';
  document.getElementById('new-preview').style.display = 'none';
}

function setDesignImageFromPath(path) {
  document.getElementById('file-input').value = '';
  document.getElementById('url-input').value = path;
  previewUrl(path);
}
</script>
@endpush

@endsection
