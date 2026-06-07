<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Two-Factor Verification — Michael Agbozo</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
@vite(['resources/css/dashboard.css'])
</head>
<body>
<div class="login-wrap">
  <div class="login-card">
    <div class="login-logo">Michael<span>.</span></div>
    <p class="login-sub">Enter the 6-digit code from your authenticator app</p>

    @if($errors->has('code'))
      <div class="alert alert-error">{{ $errors->first('code') }}</div>
    @endif

    <form method="POST" action="{{ route('two-factor.verify') }}">
      @csrf
      <div class="form-group">
        <label class="f-label">Authentication code</label>
        <input class="f-input" type="text" inputmode="numeric" autocomplete="one-time-code" name="code" placeholder="000000 or recovery code" maxlength="32" required autofocus/>
      </div>
      <button class="login-submit" type="submit">Verify</button>
    </form>

    <p style="text-align:center;margin-top:1.5rem;font-size:.75rem;color:var(--dim)">
      Lost your phone? You can enter one of your recovery codes instead.<br/>
      <a href="{{ route('login') }}" style="color:var(--muted)">← Back to login</a>
    </p>
  </div>
</div>
</body>
</html>
