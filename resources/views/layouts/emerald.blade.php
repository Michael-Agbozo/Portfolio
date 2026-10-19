<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@include('partials.seo-head')
<link rel="preload" href="/fonts/sora-latin.woff2" as="font" type="font/woff2" crossorigin/>
<link rel="preload" href="/fonts/dm-sans-latin.woff2" as="font" type="font/woff2" crossorigin/>
{{-- Paint the dark background immediately so there is no white flash while the stylesheet loads. --}}
<style>html,body{background:#050B09;color:#E8F2EE}</style>
@vite(['resources/css/emerald.css'])
@stack('head')
</head>
<body class="em-body">

<a href="#main" class="em-skip">{{ __('Skip to content') }}</a>

<header class="em-header" id="em-header">
  <div class="em-wrap em-header-row">
    <a href="/" class="em-logo" aria-label="{{ __('Michael Agbozo — home') }}">
      <svg aria-hidden="true" width="34" height="24" viewBox="0 0 34 24"><path d="M4 22V2h6l7 10 7-10h6v20h-6V12l-7 9-7-9v10z" fill="currentColor"/></svg>
      <span>agbozo</span>
    </a>
    <button type="button" class="em-menu-btn" id="em-menu-btn" aria-expanded="false" aria-controls="em-nav" aria-label="{{ __('Open menu') }}">
      <svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
    <nav class="em-nav" id="em-nav" aria-label="{{ __('Main') }}">
      <a href="/#services">{{ __('Services') }}</a>
      <a href="/#work">{{ __('Work') }}</a>
      <a href="/#designs">{{ __('Designs') }}</a>
      <a href="/#about">{{ __('About') }}</a>
      <a href="/#contact" class="em-btn em-btn-mint em-btn-sm">{{ __('+ Start a project') }}</a>
      <details class="em-lang">
        <summary aria-label="{{ __('Language') }}">
          <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20"/></svg>
          <span>{{ strtoupper(app()->getLocale()) }}</span>
        </summary>
        <ul>
          @foreach(config('app.supported_locales') as $code => $language)
          <li><a href="{{ route('language.switch', $code) }}" hreflang="{{ $code }}" lang="{{ $code }}" rel="nofollow" @if($code === app()->getLocale()) aria-current="true" @endif>{{ $language }}</a></li>
          @endforeach
        </ul>
      </details>
    </nav>
  </div>
</header>

<main id="main">
@yield('content')
</main>

<footer class="em-footer">
  <div class="em-wrap em-footer-row">
    <span class="em-logo em-logo-lg">
      <svg aria-hidden="true" width="44" height="31" viewBox="0 0 34 24"><path d="M4 22V2h6l7 10 7-10h6v20h-6V12l-7 9-7-9v10z" fill="currentColor"/></svg>
      <span>agbozo</span>
    </span>
    <div class="em-footer-links">
      <a href="https://www.instagram.com/mykell_writes/" target="_blank" rel="noopener">Instagram</a>
      <a href="https://twitter.com/mykell_Writes" target="_blank" rel="noopener">X / Twitter</a>
      <a href="https://web.facebook.com/mykell.writes.official" target="_blank" rel="noopener">Facebook</a>
      <span>&copy; {{ date('Y') }} Michael Agbozo</span>
    </div>
  </div>
</footer>

{{-- FLOATING WHATSAPP BUTTON --}}
@php
  $whatsappText = "Hi Michael, I found your portfolio and I'd like to reach out.\n\nName:\nEmail:\nHow can you help me:";
  $whatsappUrl = 'https://wa.me/233248581824?text='.rawurlencode($whatsappText);
@endphp
<a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" aria-label="{{ __('Message me on WhatsApp') }}" class="em-whatsapp">
  <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff" aria-hidden="true">
    <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm0 18.13h-.01a8.2 8.2 0 0 1-4.18-1.14l-.3-.18-3.12.82.83-3.04-.2-.31a8.22 8.22 0 0 1-1.26-4.37c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.83 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.55-3.7 8.21-8.25 8.21zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.17.25-.64.81-.78.97-.14.17-.29.19-.54.06-.25-.12-1.04-.38-1.99-1.22-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.16-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43-.14-.01-.31-.01-.47-.01-.17 0-.43.06-.66.31-.23.25-.86.84-.86 2.04 0 1.21.88 2.38 1 2.54.12.17 1.74 2.65 4.21 3.72.59.25 1.05.4 1.41.52.59.19 1.13.16 1.55.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.1-.23-.16-.48-.28z"/>
  </svg>
</a>

<script>
  // Mobile menu
  (function () {
    const btn = document.getElementById('em-menu-btn');
    const nav = document.getElementById('em-nav');
    btn.addEventListener('click', () => {
      const open = nav.classList.toggle('is-open');
      btn.setAttribute('aria-expanded', String(open));
    });
    nav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
      nav.classList.remove('is-open');
      btn.setAttribute('aria-expanded', 'false');
    }));
  })();
</script>
@stack('scripts')
</body>
</html>
