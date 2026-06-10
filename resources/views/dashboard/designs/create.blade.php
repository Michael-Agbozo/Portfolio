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

  <form method="POST" action="{{ route('dashboard.designs.store') }}" enctype="multipart/form-data">
    @csrf

    {{-- File upload --}}
    <div class="form-group">
      <label class="f-label">Upload Image File</label>
      <div style="display:flex;gap:.6rem;flex-wrap:wrap;align-items:center">
        <label class="btn btn-secondary btn-sm" style="cursor:pointer">
          ↑ Upload Image
          <input type="file" name="image" id="file-input" accept="image/*"
            onchange="previewFile(this)" style="display:none"/>
        </label>
        <button type="button" class="btn btn-secondary btn-sm" onclick="openMediaPicker('design')">◈ Choose from Library</button>
      </div>
      @error('image')<div class="field-error">{{ $message }}</div>@enderror
      <div class="f-hint">JPG, PNG, WEBP — max 100 MB</div>
    </div>

    {{-- Preview --}}
    <div id="img-preview" style="display:none;margin-bottom:1rem">
      <img id="preview-img" src="" alt="Preview"
        style="max-width:100%;max-height:220px;object-fit:contain;border-radius:8px;border:1px solid var(--line);background:var(--bg3);display:block"/>
    </div>

    {{-- Divider --}}
    <div style="display:flex;align-items:center;gap:1rem;margin:1.25rem 0;color:var(--dim);font-size:.72rem;text-transform:uppercase;letter-spacing:.1em">
      <div style="flex:1;height:1px;background:var(--line)"></div>
      or paste a URL
      <div style="flex:1;height:1px;background:var(--line)"></div>
    </div>

    {{-- URL input --}}
    <div class="form-group">
      <label class="f-label">Image URL</label>
      <input class="f-input {{ $errors->has('src') ? 'is-error' : '' }}" type="text" name="src" id="src-input"
        value="{{ old('src') }}" placeholder="https://cdn.example.com/image.jpg" oninput="previewUrl(this.value)"/>
      @error('src')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    {{-- Alt text --}}
    <div class="form-group">
      <label class="f-label">Alt Text *</label>
      <input class="f-input {{ $errors->has('alt') ? 'is-error' : '' }}" type="text" name="alt"
        value="{{ old('alt') }}" placeholder="Describe the image e.g. 'Easter Conference Flyer'"/>
      @error('alt')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Add to Gallery</button>
      <a href="{{ route('dashboard.designs.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>

@include('dashboard.partials._media-picker')

@push('scripts')
<script>
async function previewFile(input) {
  const file = input.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = e => {
    document.getElementById('preview-img').src = e.target.result;
    document.getElementById('img-preview').style.display = 'block';
    document.getElementById('src-input').value = '';
  };
  reader.readAsDataURL(file);
  try {
    const path = await instantUpload(file);
    document.getElementById('src-input').value = path;
    document.getElementById('preview-img').src = path;
    input.value = '';
  } catch (err) {
    alert('Upload failed: ' + err.message);
    input.value = '';
    document.getElementById('img-preview').style.display = 'none';
  }
}

function previewUrl(url) {
  const wrap = document.getElementById('img-preview');
  const img  = document.getElementById('preview-img');
  document.getElementById('file-input').value = '';
  if (url.trim()) {
    img.src = url;
    wrap.style.display = 'block';
  } else {
    wrap.style.display = 'none';
  }
}

function setDesignImageFromPath(path) {
  document.getElementById('file-input').value = '';
  document.getElementById('src-input').value = path;
  previewUrl(path);
}
</script>
@endpush

@endsection
