@extends('dashboard.layouts.app')

@section('title', 'Security')
@section('page-title', 'Security')
@section('breadcrumb') Security @endsection

@section('content')

<div class="card" style="max-width:640px">
  <h3 style="font-family:'Syne',sans-serif;font-size:1rem;margin:0 0 .4rem">Two-factor authentication</h3>
  <p style="font-size:.82rem;color:var(--muted);line-height:1.6;margin:0 0 1.2rem">
    Adds a second step to your login — after your password, you'll also need a 6-digit code from
    an authenticator app (like Google Authenticator or Authy) on your phone. This means even if
    someone learns your password, they still can't get into your dashboard.
  </p>

  @if($user->hasTwoFactorEnabled())
    <div class="alert alert-success" style="margin-bottom:1.2rem">
      Two-factor authentication is <strong>turned on</strong>.
    </div>

    @if($user->two_factor_recovery_codes)
      <div style="margin-bottom:1.2rem">
        <div class="f-label" style="margin-bottom:.5rem">Recovery codes</div>
        <p style="font-size:.78rem;color:var(--dim);line-height:1.6;margin:0 0 .6rem">
          If you ever lose your phone, you can use one of these one-time codes to get back in instead.
          Each code only works once — write them down and keep them somewhere safe.
        </p>
        <div style="background:var(--bg);border:1px solid var(--line);border-radius:10px;padding:.9rem 1.1rem;font-family:monospace;font-size:.82rem;line-height:1.9;color:var(--text)">
          @foreach($user->two_factor_recovery_codes as $code)
            <div>{{ $code }}</div>
          @endforeach
        </div>
      </div>

      <form method="POST" action="{{ route('dashboard.security.recovery-codes') }}" style="display:inline-block;margin-right:.6rem">
        @csrf
        <button class="btn btn-secondary btn-sm" type="submit" onclick="return confirm('Generate new recovery codes? Your existing codes will stop working.')">Generate new codes</button>
      </form>
    @endif

    <form method="POST" action="{{ route('dashboard.security.disable') }}" style="margin-top:1.2rem;border-top:1px solid var(--line);padding-top:1.2rem">
      @csrf @method('DELETE')
      <div class="form-group">
        <label class="f-label">Confirm your password to turn it off</label>
        <input class="f-input @error('password') is-error @enderror" type="password" name="password" placeholder="••••••••" required/>
        @error('password') <div class="field-error">{{ $message }}</div> @enderror
      </div>
      <button class="btn btn-danger btn-sm" type="submit">Turn off two-factor authentication</button>
    </form>

  @elseif($qrCode)
    <div class="alert" style="margin-bottom:1.2rem;background:rgba(232,83,26,.1);border:1px solid rgba(232,83,26,.3);color:var(--orange)">
      Setup started — scan the QR code below, then enter the 6-digit code it shows you to finish turning it on.
    </div>

    <ol style="font-size:.82rem;color:var(--muted);line-height:1.8;margin:0 0 1.2rem;padding-left:1.2rem">
      <li>Open your authenticator app (Google Authenticator, Authy, 1Password, etc.)</li>
      <li>Scan this QR code with it</li>
      <li>Type the 6-digit code it shows you into the box below</li>
    </ol>

    <div style="background:#fff;display:inline-block;padding:1rem;border-radius:10px;margin-bottom:1.2rem">
      {!! $qrCode !!}
    </div>

    <form method="POST" action="{{ route('dashboard.security.confirm') }}">
      @csrf
      <div class="form-group" style="max-width:220px">
        <label class="f-label">6-digit code</label>
        <input class="f-input @error('code') is-error @enderror" type="text" inputmode="numeric" autocomplete="one-time-code" name="code" placeholder="000000" maxlength="6" required autofocus/>
        @error('code') <div class="field-error">{{ $message }}</div> @enderror
      </div>
      <button class="btn btn-primary btn-sm" type="submit">Confirm and turn on</button>
    </form>
  @else
    <form method="POST" action="{{ route('dashboard.security.enable') }}">
      @csrf
      <button class="btn btn-primary btn-sm" type="submit">Set up two-factor authentication</button>
    </form>
  @endif
</div>

@endsection
