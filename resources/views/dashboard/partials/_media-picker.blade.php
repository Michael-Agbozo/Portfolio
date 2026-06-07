{{-- Reusable media-library picker modal. Include once per page; open with openMediaPicker('feature'|'gallery') --}}
<div id="media-picker-overlay" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.7);align-items:center;justify-content:center;padding:2rem">
  <div style="background:var(--bg2);border:1px solid var(--line);border-radius:12px;max-width:880px;width:100%;max-height:85vh;display:flex;flex-direction:column;overflow:hidden">

    <div style="display:flex;justify-content:space-between;align-items:center;padding:1.1rem 1.5rem;border-bottom:1px solid var(--line)">
      <div class="card-title" style="margin-bottom:0" id="media-picker-title">Choose from Media Library</div>
      <button type="button" class="btn btn-secondary btn-sm" onclick="closeMediaPicker()">Close</button>
    </div>

    <div style="padding:1.25rem 1.5rem;overflow-y:auto;flex:1">
      @if(empty($mediaFiles))
        <div class="empty-state">
          <div class="empty-icon">◈</div>
          <div class="empty-title">No uploaded files yet</div>
          <p style="margin-top:.5rem;font-size:.8rem;color:var(--dim)">Upload an image first and it'll show up here.</p>
        </div>
      @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:.75rem">
          @foreach($mediaFiles as $file)
          <div class="media-picker-item" data-path="{{ $file['url'] }}"
               onclick="mediaPickerSelect(this)"
               style="cursor:pointer;border:2px solid var(--line);border-radius:8px;overflow:hidden;position:relative;background:var(--bg3);transition:border-color .25s">
            <div style="aspect-ratio:1/1;overflow:hidden">
              <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block"/>
            </div>
            <div class="media-picker-check" style="display:none;position:absolute;top:.4rem;right:.4rem;width:22px;height:22px;border-radius:50%;background:var(--orange);color:#fff;align-items:center;justify-content:center;font-size:.7rem;font-weight:700">✓</div>
          </div>
          @endforeach
        </div>
      @endif
    </div>

    <div style="padding:1rem 1.5rem;border-top:1px solid var(--line);display:flex;justify-content:flex-end;gap:.6rem">
      <button type="button" class="btn btn-secondary btn-sm" onclick="closeMediaPicker()">Cancel</button>
      <button type="button" class="btn btn-primary btn-sm" id="media-picker-confirm" onclick="mediaPickerConfirm()">Use Selected</button>
    </div>
  </div>
</div>

@once
@push('scripts')
<script>
let mediaPickerMode = 'feature';
let mediaPickerSelection = [];

function openMediaPicker(mode) {
  mediaPickerMode = mode;
  mediaPickerSelection = [];
  document.querySelectorAll('.media-picker-item').forEach(el => {
    el.style.borderColor = 'var(--line)';
    el.querySelector('.media-picker-check').style.display = 'none';
  });
  const titles = {
    feature: 'Choose Feature Image',
    design:  'Choose Image',
    gallery: 'Choose Images for Gallery',
  };
  const confirmLabels = {
    feature: 'Use Image',
    design:  'Use Image',
    gallery: 'Add Selected',
  };
  document.getElementById('media-picker-title').textContent   = titles[mode] || titles.gallery;
  document.getElementById('media-picker-confirm').textContent = confirmLabels[mode] || confirmLabels.gallery;
  document.getElementById('media-picker-overlay').style.display = 'flex';
}

function closeMediaPicker() {
  document.getElementById('media-picker-overlay').style.display = 'none';
}

function mediaPickerSelect(el) {
  const path = el.dataset.path;
  const check = el.querySelector('.media-picker-check');

  if (mediaPickerMode === 'feature' || mediaPickerMode === 'design') {
    document.querySelectorAll('.media-picker-item').forEach(other => {
      other.style.borderColor = 'var(--line)';
      other.querySelector('.media-picker-check').style.display = 'none';
    });
    el.style.borderColor = 'var(--orange)';
    check.style.display = 'flex';
    mediaPickerSelection = [path];
    return;
  }

  const idx = mediaPickerSelection.indexOf(path);
  if (idx === -1) {
    mediaPickerSelection.push(path);
    el.style.borderColor = 'var(--orange)';
    check.style.display = 'flex';
  } else {
    mediaPickerSelection.splice(idx, 1);
    el.style.borderColor = 'var(--line)';
    check.style.display = 'none';
  }
}

function mediaPickerConfirm() {
  if (!mediaPickerSelection.length) {
    closeMediaPicker();
    return;
  }

  if (mediaPickerMode === 'feature') {
    setFeatureImageFromPath(mediaPickerSelection[0]);
  } else if (mediaPickerMode === 'design') {
    setDesignImageFromPath(mediaPickerSelection[0]);
  } else {
    appendGalleryPaths(mediaPickerSelection);
  }

  closeMediaPicker();
}
</script>
@endpush
@endonce
