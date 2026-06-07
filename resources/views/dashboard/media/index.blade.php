@extends('dashboard.layouts.app')

@section('title', 'Media Library')
@section('page-title', 'Media Library')
@section('breadcrumb') Media @endsection

@section('content')

<div class="card" style="margin-bottom:1.25rem">
  <div class="card-title">Upload Files</div>

  <form method="POST" action="{{ route('dashboard.media.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label class="f-label">Image Files *</label>
      <input class="f-input {{ $errors->has('files') || $errors->has('files.*') ? 'is-error' : '' }}" type="file"
             name="files[]" id="media-upload-input" accept="image/*" multiple
             onchange="previewMediaUploads(this)" style="padding:.5rem .9rem;cursor:pointer"/>
      @error('files')<div class="field-error">{{ $message }}</div>@enderror
      @error('files.*')<div class="field-error">{{ $message }}</div>@enderror
      <div class="f-hint">Select multiple — JPG, PNG, WEBP, GIF — max 25 MB each. Once uploaded, pick them from the library anywhere — on a Project or a Design.</div>
    </div>

    <div id="media-upload-list" style="margin-bottom:1rem"></div>

    <div class="form-actions" style="margin-top:0;padding-top:0;border-top:none">
      <button class="btn btn-primary" type="submit">↑ Upload</button>
    </div>
  </form>
</div>

<div class="card">

  {{-- Header --}}
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;flex-wrap:wrap;gap:.75rem">
    <div class="card-title" style="margin-bottom:0">
      Media Library
      @if($counts['all'])
        <span style="font-size:.72rem;font-weight:400;color:var(--dim)">({{ $counts[$filter] ?? $counts['all'] }} {{ ($counts[$filter] ?? $counts['all']) === 1 ? 'file' : 'files' }} — {{ round($totalSize / 1048576, 1) }} MB)</span>
      @endif
    </div>
    {{-- Filter tabs --}}
    <div style="display:flex;gap:.4rem;flex-wrap:wrap">
      <a href="{{ route('dashboard.media.index', ['filter' => 'all']) }}" class="media-tab {{ $filter === 'all' ? 'active' : '' }}">All <span class="media-count">{{ $counts['all'] }}</span></a>
      <a href="{{ route('dashboard.media.index', ['filter' => 'projects']) }}" class="media-tab {{ $filter === 'projects' ? 'active' : '' }}">Used in Projects <span class="media-count">{{ $counts['projects'] }}</span></a>
      <a href="{{ route('dashboard.media.index', ['filter' => 'designs']) }}" class="media-tab {{ $filter === 'designs' ? 'active' : '' }}">Used in Designs <span class="media-count">{{ $counts['designs'] }}</span></a>
      <a href="{{ route('dashboard.media.index', ['filter' => 'unused']) }}" class="media-tab {{ $filter === 'unused' ? 'active' : '' }}">Unused <span class="media-count">{{ $counts['unused'] }}</span></a>
    </div>
  </div>

  @if($files->isEmpty())
    <div class="empty-state">
      <div class="empty-icon">◈</div>
      <div class="empty-title">{{ $filter === 'all' ? 'No uploaded files yet' : 'No files in this category' }}</div>
      <p style="margin-top:.5rem;font-size:.8rem;color:var(--dim)">
        @if($filter === 'all')
          Upload images above, or through Designs / project entries.
        @else
          Try a different filter, or <a href="{{ route('dashboard.media.index') }}">view all files</a>.
        @endif
      </p>
    </div>
  @else
    <div class="media-grid" id="media-grid">
      @foreach($files as $file)
      <div class="media-item" data-folder="{{ $file['folder'] }}">
        <div class="media-thumb">
          <img src="{{ $file['url'] }}" alt="{{ $file['alt'] ?: $file['name'] }}" loading="lazy"/>
          <div class="media-overlay">
            <a href="{{ $file['url'] }}" target="_blank" class="media-action-btn" title="View full size">↗</a>
            <button class="media-action-btn media-copy-btn" title="Copy link" onclick="copyUrl('{{ $file['url'] }}', this)">⎘</button>
            <button type="button" class="media-action-btn" title="Rename / edit alt text" onclick="toggleMediaEdit('{{ $loop->index }}')">✎</button>
            <form method="POST" action="{{ route('dashboard.media.destroy', ltrim($file['path'], '/')) }}"
              onsubmit="return confirm('Delete {{ $file['name'] }}? This cannot be undone.')" style="margin:0">
              @csrf @method('DELETE')
              <button class="media-action-btn media-delete-btn" type="submit" title="Delete">✕</button>
            </form>
          </div>
        </div>
        <div class="media-info">
          <div class="media-name" title="{{ $file['name'] }}">{{ $file['title'] ?: $file['name'] }}</div>
          <div class="media-meta">
            <span class="media-folder-badge">{{ $file['folder'] === 'unused' ? 'not used yet' : 'used in ' . $file['folder'] }}</span>
            {{ round($file['size'] / 1024) }} KB
          </div>
        </div>

        {{-- Edit panel: display name + alt text --}}
        <div class="media-edit-panel" id="media-edit-{{ $loop->index }}" style="display:none">
          <form method="POST" action="{{ route('dashboard.media.update', ltrim($file['path'], '/')) }}">
            @csrf @method('PATCH')
            <div class="form-group" style="margin-bottom:.5rem">
              <label class="f-label">Display Name</label>
              <input class="f-input" type="text" name="name" value="{{ $file['title'] }}" placeholder="{{ $file['name'] }}"/>
            </div>
            <div class="form-group" style="margin-bottom:.5rem">
              <label class="f-label">Alt Text</label>
              <input class="f-input" type="text" name="alt" value="{{ $file['alt'] }}" placeholder="Describe this image"/>
            </div>
            <div style="display:flex;gap:.4rem">
              <button class="btn btn-primary btn-sm" type="submit">Save</button>
              <button type="button" class="btn btn-secondary btn-sm" onclick="toggleMediaEdit('{{ $loop->index }}')">Cancel</button>
            </div>
          </form>
        </div>
      </div>
      @endforeach
    </div>

    @if($files->hasPages())
      <div style="display:flex;justify-content:center;align-items:center;gap:.4rem;margin-top:1.5rem;flex-wrap:wrap">
        @if($files->onFirstPage())
          <span class="btn btn-secondary btn-sm" style="opacity:.4;cursor:default">&larr; Previous</span>
        @else
          <a href="{{ $files->previousPageUrl() }}" class="btn btn-secondary btn-sm">&larr; Previous</a>
        @endif

        <span style="font-size:.72rem;color:var(--dim);padding:0 .5rem">Page {{ $files->currentPage() }} of {{ $files->lastPage() }}</span>

        @if($files->hasMorePages())
          <a href="{{ $files->nextPageUrl() }}" class="btn btn-secondary btn-sm">Next &rarr;</a>
        @else
          <span class="btn btn-secondary btn-sm" style="opacity:.4;cursor:default">Next &rarr;</span>
        @endif
      </div>
    @endif
  @endif

</div>

@push('scripts')
<script>
function previewMediaUploads(input) {
  const list = document.getElementById('media-upload-list');
  list.innerHTML = '';
  [...input.files].forEach(file => {
    const row = document.createElement('div');
    row.textContent = '✓ ' + file.name;
    row.style.cssText = 'font-size:.72rem;color:var(--muted);padding:.15rem 0';
    list.appendChild(row);
  });
}

function toggleMediaEdit(index) {
  const panel = document.getElementById('media-edit-' + index);
  panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
}

function copyUrl(url, btn) {
  navigator.clipboard.writeText(window.location.origin + url).then(() => {
    const orig = btn.textContent;
    btn.textContent = '✓';
    setTimeout(() => btn.textContent = orig, 1500);
  });
}
</script>
@endpush

@endsection
