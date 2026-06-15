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

  <form method="POST" action="{{ route('dashboard.projects.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-grid-2">
      <div class="form-group">
        <label class="f-label">Label / Number</label>
        <input class="f-input {{ $errors->has('num') ? 'is-error' : '' }}" type="text" name="num" value="{{ old('num', $suggestedNum) }}" readonly/>
        <div class="f-hint">Automatically set when the project is saved</div>
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

    {{-- ─── Feature Image ─────────────────────────── --}}
    <div class="form-group">
      <label class="f-label">Feature Image</label>
      <div class="f-hint" style="margin-top:0;margin-bottom:.6rem">The main image shown on the project card and at the top of its page</div>

      <div id="feature-preview-wrap" style="display:none;margin-bottom:.9rem">
        <img id="feature-preview-img" src="" alt="Feature image preview"
             style="max-width:100%;max-height:220px;object-fit:contain;border-radius:8px;border:1px solid var(--line);background:var(--bg3);display:block"/>
      </div>

      <input type="hidden" name="feature_image_path" id="feature-image-path" value="{{ old('feature_image_path') }}"/>

      <div style="display:flex;gap:.6rem;flex-wrap:wrap;align-items:center">
        <label class="btn btn-secondary btn-sm" style="cursor:pointer">
          ↑ Upload Image
          <input type="file" name="feature_image_file" id="feature-image-file" accept="image/*"
                 onchange="previewFeatureFile(this)" style="display:none"/>
        </label>
        <button type="button" class="btn btn-secondary btn-sm" onclick="openMediaPicker('feature')">◈ Choose from Library</button>
      </div>
      @error('feature_image_file')<div class="field-error">{{ $message }}</div>@enderror
      @error('feature_image_path')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    {{-- ─── Other / Gallery Images ─────────────────── --}}
    <div class="form-group">
      <label class="f-label">Other Images</label>
      <div class="f-hint" style="margin-top:0;margin-bottom:.6rem">Extra images shown as a gallery on the project's detail page</div>

      <div style="display:flex;gap:.6rem;flex-wrap:wrap;align-items:center;margin-bottom:.6rem">
        <label class="btn btn-secondary btn-sm" style="cursor:pointer">
          ↑ Upload Images
          <input type="file" name="gallery_files[]" id="gallery-files" accept="image/*" multiple
                 onchange="previewGalleryFiles(this)" style="display:none"/>
        </label>
        <button type="button" class="btn btn-secondary btn-sm" onclick="openMediaPicker('gallery')">◈ Choose from Library</button>
      </div>
      <div id="gallery-file-list" style="margin-bottom:.6rem"></div>

      <textarea class="f-textarea" name="images" id="images-textarea" placeholder="/storage/projects/my-image.jpg&#10;/storage/projects/another.jpg" style="min-height:100px">{{ old('images') }}</textarea>
      <div class="f-hint">One image path per line — uploaded files and library picks are added here automatically, or paste a URL/path manually</div>
      @error('gallery_files.*')<div class="field-error">{{ $message }}</div>@enderror
      @error('images')<div class="field-error">{{ $message }}</div>@enderror
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

@include('dashboard.partials._media-picker')

@push('scripts')
<script>
function showFeaturePreview(src) {
  document.getElementById('feature-preview-img').src = src;
  document.getElementById('feature-preview-wrap').style.display = 'block';
}

async function previewFeatureFile(input) {
  const file = input.files[0];
  if (!file) return;
  const label = input.closest('label');
  label.style.opacity = '0.6';
  label.style.pointerEvents = 'none';
  const reader = new FileReader();
  reader.onload = e => showFeaturePreview(e.target.result);
  reader.readAsDataURL(file);
  try {
    const path = await instantUpload(file);
    document.getElementById('feature-image-path').value = path;
    input.value = '';
    showFeaturePreview(path);
  } catch (err) {
    alert('Upload failed: ' + err.message);
    input.value = '';
    document.getElementById('feature-preview-wrap').style.display = 'none';
  } finally {
    label.style.opacity = '';
    label.style.pointerEvents = '';
  }
}

function setFeatureImageFromPath(path) {
  document.getElementById('feature-image-path').value = path;
  document.getElementById('feature-image-file').value = '';
  showFeaturePreview(path);
}

async function previewGalleryFiles(input) {
  const files = [...input.files];
  if (!files.length) return;
  const list = document.getElementById('gallery-file-list');
  list.innerHTML = '';
  const rows = files.map(file => {
    const row = document.createElement('div');
    row.textContent = '⟳ ' + file.name + ' — uploading…';
    row.style.cssText = 'font-size:.72rem;color:var(--muted);padding:.15rem 0';
    list.appendChild(row);
    return row;
  });
  const results = await Promise.allSettled(files.map(f => instantUpload(f)));
  results.forEach((result, i) => {
    if (result.status === 'fulfilled') {
      rows[i].textContent = '✓ ' + files[i].name;
      appendGalleryPaths([result.value]);
    } else {
      rows[i].textContent = '✕ ' + files[i].name + ' — failed';
      rows[i].style.color = '#e55';
    }
  });
  input.value = '';
}

function appendGalleryPaths(paths) {
  const ta = document.getElementById('images-textarea');
  const lines = ta.value.split('\n').map(s => s.trim()).filter(Boolean);
  paths.forEach(p => { if (!lines.includes(p)) lines.push(p); });
  ta.value = lines.join('\n');
}
</script>
@endpush

@endsection
