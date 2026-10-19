<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta name="robots" content="noindex, nofollow"/>
<title>Sign In — Michael Agbozo</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"/>
<link rel="preload" href="/fonts/sora-latin.woff2" as="font" type="font/woff2" crossorigin/>
<link rel="preload" href="/fonts/dm-sans-latin.woff2" as="font" type="font/woff2" crossorigin/>
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
      <p class="em-eyebrow" style="margin-bottom:8px">Dashboard</p>
      <h1>Welcome <span class="em-mint">back.</span></h1>
      <p style="margin-top:8px">Sign in to your dashboard</p>
    </div>

    @if($errors->has('email'))
      <div class="em-alert em-alert-err" role="alert">{{ $errors->first('email') }}</div>
    @endif

    <form method="POST" action="{{ url('/login') }}" class="em-stack">
      @csrf
      <label class="em-field">Email
        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" autocomplete="email" required autofocus/>
      </label>
      <label class="em-field">Password
        <input type="password" name="password" placeholder="••••••••" autocomplete="current-password" required/>
      </label>
      <label class="em-check">
        <input type="checkbox" name="remember"/> Remember me
      </label>
      <button class="em-btn em-btn-mint" type="submit" style="border:0">Sign In</button>
    </form>

    <p class="em-auth-foot"><a href="/">← Back to portfolio</a></p>
  </div>
</main>
</body>
</html>
