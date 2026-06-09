@extends('dashboard.layouts.app')

@section('title', 'Settings — CV')
@section('page-title', 'Settings')
@section('breadcrumb')
  <a href="{{ route('dashboard.profile.show') }}">Settings</a>
  <span class="dash-breadcrumb-sep">/</span>
  CV
@endsection

@section('content')

@include('dashboard.settings._tabs')

<div class="form-card">
  <div class="form-section-label">Current CV</div>

  @if($cv['exists'])
    <p style="color:var(--muted);font-size:.85rem;margin-bottom:1rem">
      Your public CV is available at
      <a href="{{ $cv['url'] }}" target="_blank" rel="noopener" style="color:var(--orange)">/cv/michael-agbozo-cv.pdf</a>.
    </p>
    <p class="f-hint" style="margin-bottom:1.25rem">
      Last updated {{ date('M j, Y g:ia', $cv['updated_at']) }} — {{ round($cv['size'] / 1048576, 2) }} MB
    </p>
  @else
    <p style="color:var(--muted);font-size:.85rem;margin-bottom:1.25rem">
      No CV has been uploaded yet. The public download button will work after you upload one here.
    </p>
  @endif

  <form method="POST" action="{{ route('dashboard.cv.update') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label class="f-label">Upload updated CV</label>
      <input class="f-input @error('cv') is-error @enderror" type="file" name="cv" accept="application/pdf,.pdf" required style="padding:.5rem .9rem;cursor:pointer"/>
      @error('cv')<div class="field-error">{{ $message }}</div>@enderror
      <div class="f-hint">PDF only. Max 10 MB. Uploading replaces the current public CV.</div>
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Upload CV</button>
      @if($cv['exists'])
        <a class="btn btn-secondary" href="{{ $cv['url'] }}" target="_blank" rel="noopener">View current CV</a>
      @endif
    </div>
  </form>
</div>

@endsection
