<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Sign In — Michael Agbozo</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
@vite(['resources/css/dashboard.css'])
</head>
<body>
<div class="login-wrap">
  <div class="login-card">
    <div class="login-logo">Michael<span>.</span></div>
    <p class="login-sub">Sign in to your dashboard</p>

    @if($errors->has('email'))
      <div class="alert alert-error">{{ $errors->first('email') }}</div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
      @csrf
      <div class="form-group">
        <label class="f-label">Email</label>
        <input class="f-input" type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" required autofocus/>
      </div>
      <div class="form-group">
        <label class="f-label">Password</label>
        <input class="f-input" type="password" name="password" placeholder="••••••••" required/>
      </div>
      <label class="login-remember" style="margin-top:.5rem">
        <input type="checkbox" name="remember"/> Remember me
      </label>
      <button class="login-submit" type="submit">Sign In</button>
    </form>

    <p style="text-align:center;margin-top:1.5rem;font-size:.75rem;color:var(--dim)">
      <a href="/" style="color:var(--muted)">← Back to portfolio</a>
    </p>
  </div>
</div>
</body>
</html>
