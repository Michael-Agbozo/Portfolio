<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta name="robots" content="noindex, nofollow"/>
<title>Two-Factor Verification — Michael Agbozo</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,400..600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<style>html,body{background:#050B09;color:#E8F2EE}</style>
@vite(['resources/css/emerald.css'])
</head>
<body class="em-body">
<main class="em-auth">
  @include('partials.em-backdrop')
  <div class="em-auth-card">
    <a href="/" class="em-logo" aria-label="Michael Agbozo — home">
      <svg aria-hidden="true" width="34" height="24" viewBox="0 0 34 24"><path d="M4 22V2h6l7 10 7-10h6v20h-6V12l-7 9-7-9v10z" fill="currentColor"/></svg>
      <span>agbozo</span>
    </a>
    <div>
      <p class="em-eyebrow" style="margin-bottom:8px">Two-factor check</p>
      <h1>One more <span class="em-mint">step.</span></h1>
      <p style="margin-top:8px">Enter the 6-digit code from your authenticator app</p>
    </div>

    @if($errors->has('code'))
      <div class="em-alert em-alert-err" role="alert">{{ $errors->first('code') }}</div>
    @endif

    <form method="POST" action="{{ route('two-factor.verify') }}" class="em-stack">
      @csrf
      <label class="em-field">Authentication code
        <input type="text" inputmode="numeric" autocomplete="one-time-code" name="code" placeholder="000000 or recovery code" maxlength="32" required autofocus/>
      </label>
      <button class="em-btn em-btn-mint" type="submit" style="border:0">Verify</button>
    </form>

    <p class="em-auth-foot">
      Lost your phone? You can enter one of your recovery codes instead.<br/>
      <a href="{{ route('login') }}">← Back to login</a>
    </p>
  </div>
</main>
</body>
</html>
