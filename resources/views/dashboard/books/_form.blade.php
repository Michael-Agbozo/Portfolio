@csrf

<div class="form-group">
  <label class="f-label">Title *</label>
  <input class="f-input {{ $errors->has('title') ? 'is-error' : '' }}" type="text" name="title"
    value="{{ old('title', $book->title) }}" placeholder="e.g. Funeral programme for ..." required maxlength="200"/>
  @error('title')<div class="field-error">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label class="f-label">Link</label>
  <div style="display:flex;align-items:center;gap:.4rem">
    <span style="color:var(--dim);font-size:.85rem;white-space:nowrap">{{ url('/books') }}/</span>
    <input class="f-input {{ $errors->has('slug') ? 'is-error' : '' }}" type="text" name="slug"
      value="{{ old('slug', $book->slug) }}" placeholder="made-from-the-title" maxlength="120"/>
  </div>
  @error('slug')<div class="field-error">{{ $message }}</div>@enderror
  <div class="f-hint">
    @if($book->exists)
      Changing this breaks QR codes you have already printed or shared.
    @else
      Leave blank to make it from the title.
    @endif
  </div>
</div>

<div class="form-group">
  <label class="f-label">Short description</label>
  <input class="f-input {{ $errors->has('description') ? 'is-error' : '' }}" type="text" name="description"
    value="{{ old('description', $book->description) }}" placeholder="Shown when the link is shared" maxlength="500"/>
  @error('description')<div class="field-error">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label class="f-label">{{ $book->exists ? 'Replace PDF' : 'PDF *' }}</label>
  <input class="f-input {{ $errors->has('pdf') ? 'is-error' : '' }}" type="file" name="pdf" accept="application/pdf,.pdf"
    {{ $book->exists ? '' : 'required' }} style="padding:.5rem .9rem;cursor:pointer"/>
  @error('pdf')<div class="field-error">{{ $message }}</div>@enderror
  <div class="f-hint">
    PDF only, max 100 MB.
    @if($book->exists)
      Leave blank to keep the current file. The link and QR code stay the same.
    @endif
  </div>
</div>
