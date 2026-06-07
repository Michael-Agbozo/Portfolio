@extends('dashboard.layouts.app')

@section('title', 'Media Library')
@section('page-title', 'Media Library')
@section('breadcrumb') Media @endsection

@section('header-actions')
  <a href="{{ route('dashboard.designs.create') }}" class="btn btn-primary btn-sm">+ Upload Design</a>
@endsection

@section('content')

<div class="card">

  {{-- Header --}}
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem">
    <div class="card-title" style="margin-bottom:0">
      Media Library
      @if(!empty($files))
        <span style="font-size:.72rem;font-weight:400;color:var(--dim)">({{ count($files) }} files — {{ round(array_sum(array_column($files, 'size')) / 1048576, 1) }} MB)</span>
      @endif
    </div>
    {{-- Filter tabs --}}
    <div style="display:flex;gap:.4rem">
      <button class="media-tab active" onclick="filterMedia('all', this)">All <span class="media-count" id="count-all"></span></button>
      <button class="media-tab" onclick="filterMedia('designs', this)">Designs <span class="media-count" id="count-designs"></span></button>
      <button class="media-tab" onclick="filterMedia('projects', this)">Projects <span class="media-count" id="count-projects"></span></button>
    </div>
  </div>

  @if(empty($files))
    <div class="empty-state">
      <div class="empty-icon">◈</div>
      <div class="empty-title">No uploaded files yet</div>
      <p style="margin-top:.5rem;font-size:.8rem;color:var(--dim)">Upload images through Designs or project entries.</p>
    </div>
  @else
    <div class="media-grid" id="media-grid">
      @foreach($files as $file)
      <div class="media-item" data-folder="{{ $file['folder'] }}">
        <div class="media-thumb">
          <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" loading="lazy"/>
          <div class="media-overlay">
            <a href="{{ $file['url'] }}" target="_blank" class="media-action-btn" title="View full size">↗</a>
            <button class="media-action-btn media-copy-btn" title="Copy URL" onclick="copyUrl('{{ $file['url'] }}', this)">⎘</button>
            <form method="POST" action="{{ route('dashboard.media.destroy', ltrim($file['path'], '/')) }}"
              onsubmit="return confirm('Delete {{ $file['name'] }}? This cannot be undone.')" style="margin:0">
              @csrf @method('DELETE')
              <button class="media-action-btn media-delete-btn" type="submit" title="Delete">✕</button>
            </form>
          </div>
        </div>
        <div class="media-info">
          <div class="media-name" title="{{ $file['name'] }}">{{ $file['name'] }}</div>
          <div class="media-meta">
            <span class="media-folder-badge">{{ $file['folder'] }}</span>
            {{ round($file['size'] / 1024) }} KB
          </div>
        </div>
      </div>
      @endforeach
    </div>
  @endif

</div>

@push('scripts')
<script>
const items = document.querySelectorAll('.media-item');

function setCounts() {
  document.getElementById('count-all').textContent     = items.length;
  document.getElementById('count-designs').textContent = [...items].filter(i => i.dataset.folder === 'designs').length;
  document.getElementById('count-projects').textContent = [...items].filter(i => i.dataset.folder === 'projects').length;
}
setCounts();

function filterMedia(folder, btn) {
  document.querySelectorAll('.media-tab').forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  items.forEach(item => {
    item.style.display = (folder === 'all' || item.dataset.folder === folder) ? '' : 'none';
  });
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
