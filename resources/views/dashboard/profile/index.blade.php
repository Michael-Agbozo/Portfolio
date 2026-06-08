@extends('dashboard.layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile')
@section('breadcrumb') Profile @endsection

@section('content')

<div style="display:flex;flex-direction:column;gap:1.5rem;max-width:680px">

  {{-- PHOTO --}}
  <div class="form-card">
    <div class="form-section-label">Profile photo</div>

    <div style="display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap">
      @if($user->avatarUrl())
        <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:1px solid var(--line)"/>
      @else
        <div style="width:72px;height:72px;border-radius:50%;background:var(--orange);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:800;font-size:1.2rem;color:var(--white)">
          {{ $user->initials() }}
        </div>
      @endif

      <div style="display:flex;gap:.6rem;flex-wrap:wrap">
        <form method="POST" action="{{ route('dashboard.profile.photo.update') }}" enctype="multipart/form-data" style="display:flex;align-items:center;gap:.6rem">
          @csrf
          <label class="btn btn-secondary btn-sm" style="margin:0">
            Upload new photo
            <input type="file" name="avatar" accept="image/*" style="display:none" onchange="this.form.requestSubmit()"/>
          </label>
        </form>

        @if($user->avatar)
          <form method="POST" action="{{ route('dashboard.profile.photo.destroy') }}" onsubmit="return confirmDelete(event, this, 'Your profile photo will be removed and your initials shown instead.', 'Remove profile photo?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm" type="submit">Remove photo</button>
          </form>
        @endif
      </div>
    </div>
    @error('avatar') <div class="field-error" style="margin-top:.8rem">{{ $message }}</div> @enderror
    <p class="f-hint" style="margin-top:.9rem">JPG, PNG or GIF. Max 5MB. Shown next to your name in the sidebar.</p>
  </div>

  {{-- CHANGE PASSWORD --}}
  <div class="form-card">
    <div class="form-section-label">Change password</div>

    <form method="POST" action="{{ route('dashboard.profile.password.update') }}">
      @csrf @method('PUT')

      <div class="form-group">
        <label class="f-label">Current password</label>
        <input class="f-input @error('current_password') is-error @enderror" type="password" name="current_password" placeholder="••••••••" required/>
        @error('current_password') <div class="field-error">{{ $message }}</div> @enderror
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="f-label">New password</label>
          <input class="f-input @error('password') is-error @enderror" type="password" name="password" placeholder="••••••••" required/>
          @error('password') <div class="field-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label class="f-label">Confirm new password</label>
          <input class="f-input" type="password" name="password_confirmation" placeholder="••••••••" required/>
        </div>
      </div>

      <div class="form-actions">
        <button class="btn btn-primary" type="submit">Update password</button>
      </div>
    </form>
  </div>

</div>

@endsection
