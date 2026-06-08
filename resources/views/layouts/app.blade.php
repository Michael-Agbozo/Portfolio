<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>@yield('title', 'Michael Agbozo — Portfolio')</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet"/>
{{-- Paint the correct background immediately, before the stylesheet finishes
     loading — otherwise the browser shows a plain white page for a moment
     on every page load/refresh. --}}
<style>html,body{background:#0c0c0c;color:#fff}html.light,html.light body{background:#fff;color:#0c0c0c}</style>
<script>
  if (localStorage.getItem('theme') === 'light') {
    document.documentElement.classList.add('light');
  }
</script>
@vite(['resources/css/app.css'])
@stack('head')
</head>
<body class="bg-bg text-white font-sans text-[15px] leading-relaxed overflow-x-hidden pb-[72px] md:pb-0">

<!-- NAV -->
<nav id="nav" class="fixed top-0 left-0 right-0 z-50 border-b border-transparent transition-all duration-300">
  <div class="max-w-[1280px] mx-auto px-5 sm:px-8 md:px-12 flex justify-between items-center py-4 md:py-5 gap-3">
    <a href="/" class="font-display font-extrabold text-[.92rem] sm:text-[1.1rem] tracking-wide text-white whitespace-nowrap shrink-0">Michael Agbozo<span class="text-orange">.</span></a>

    <ul class="hidden md:flex gap-10 list-none">
      @if(request()->is('/'))
        <li><a href="#about"    class="text-muted text-[.82rem] font-medium uppercase tracking-widest hover:text-white transition-colors">About</a></li>
        <li><a href="#services" class="text-muted text-[.82rem] font-medium uppercase tracking-widest hover:text-white transition-colors">Services</a></li>
        <li><a href="#work"     class="text-muted text-[.82rem] font-medium uppercase tracking-widest hover:text-white transition-colors">Work</a></li>
        <li><a href="#designs"  class="text-muted text-[.82rem] font-medium uppercase tracking-widest hover:text-white transition-colors">Designs</a></li>
        <li><a href="#contact"  class="text-muted text-[.82rem] font-medium uppercase tracking-widest hover:text-white transition-colors">Contact</a></li>
      @else
        <li><a href="/" class="text-muted text-[.82rem] font-medium uppercase tracking-widest hover:text-white transition-colors">Home</a></li>
      @endif
    </ul>

    <div class="flex items-center gap-2 sm:gap-3 shrink-0">
      <button id="theme-toggle" type="button" aria-label="Toggle light/dark mode"
              class="cursor-pointer w-9 h-9 flex items-center justify-center rounded-full border border-border bg-bg2 text-muted hover:border-white hover:text-white hover:bg-bg3 active:scale-95 transition-all duration-200 shrink-0">
        <svg id="theme-icon-moon" width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
        </svg>
        <svg id="theme-icon-sun" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden" aria-hidden="true">
          <circle cx="12" cy="12" r="4"/>
          <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
        </svg>
      </button>
      <a href="/cv/michael-agbozo-cv.pdf" download
         class="hidden md:inline-flex border border-border text-muted text-[.76rem] font-medium tracking-wide px-4 py-2 rounded-full hover:border-white hover:text-white transition-all">
        CV ↓
      </a>
      <a href="{{ request()->is('/') ? '#contact' : '/#contact' }}"
         class="bg-orange text-white text-[.7rem] sm:text-[.8rem] font-semibold uppercase tracking-wide px-3.5 sm:px-5 py-2 rounded-full hover:bg-orange2 transition-colors whitespace-nowrap shrink-0">
        Let's Talk
      </a>
    </div>
  </div>
</nav>

{{-- MOBILE APP-STYLE BOTTOM TAB BAR --}}
<nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-bg2/95 backdrop-blur-md border-t border-border"
     style="padding-bottom:env(safe-area-inset-bottom)">
  <div class="grid grid-cols-5 text-center">
    <a href="/" class="flex flex-col items-center gap-1 py-3 {{ request()->is('/') ? 'text-orange' : 'text-muted' }} transition-colors active:scale-90">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5H10v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/>
      </svg>
      <span class="text-[.62rem] font-medium uppercase tracking-wide">Home</span>
    </a>
    <a href="/#work" class="flex flex-col items-center gap-1 py-3 text-muted hover:text-white transition-colors active:scale-90">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/>
      </svg>
      <span class="text-[.62rem] font-medium uppercase tracking-wide">Work</span>
    </a>
    <a href="/#designs" class="flex flex-col items-center gap-1 py-3 text-muted hover:text-white transition-colors active:scale-90">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-5-5L5 21"/>
      </svg>
      <span class="text-[.62rem] font-medium uppercase tracking-wide">Designs</span>
    </a>
    <a href="/#contact" class="flex flex-col items-center gap-1 py-3 text-muted hover:text-white transition-colors active:scale-90">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>
      </svg>
      <span class="text-[.62rem] font-medium uppercase tracking-wide">Contact</span>
    </a>
    <button type="button" id="theme-toggle-mobile" aria-label="Toggle light/dark mode"
            class="flex flex-col items-center gap-1 py-3 text-muted hover:text-white transition-colors active:scale-90">
      <svg id="theme-icon-moon-mobile" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
      </svg>
      <svg id="theme-icon-sun-mobile" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden" aria-hidden="true">
        <circle cx="12" cy="12" r="4"/>
        <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
      </svg>
      <span class="text-[.62rem] font-medium uppercase tracking-wide">Theme</span>
    </button>
  </div>
</nav>

@yield('content')

<!-- FOOTER -->
<footer class="border-t border-border">
  <div class="max-w-[1280px] mx-auto px-12 py-8 flex justify-between items-center flex-wrap gap-4">
    <div class="font-display font-extrabold text-white">Michael Agbozo<span class="text-orange">.</span></div>
    <div class="flex gap-4">
      <a href="https://web.facebook.com/mykell.writes.official" target="_blank" rel="noopener" aria-label="Facebook"
         class="w-9 h-9 flex items-center justify-center rounded-full border border-border text-muted hover:text-white hover:border-white transition-colors">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
        </svg>
      </a>
      <a href="https://twitter.com/mykell_Writes" target="_blank" rel="noopener" aria-label="Twitter"
         class="w-9 h-9 flex items-center justify-center rounded-full border border-border text-muted hover:text-white hover:border-white transition-colors">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
        </svg>
      </a>
      <a href="https://www.instagram.com/mykell_writes/" target="_blank" rel="noopener" aria-label="Instagram"
         class="w-9 h-9 flex items-center justify-center rounded-full border border-border text-muted hover:text-white hover:border-white transition-colors">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6 6 0 100 12 6 6 0 000-12zm0 9.838a3.838 3.838 0 110-7.676 3.838 3.838 0 010 7.676zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
        </svg>
      </a>
    </div>
    <div class="text-dim text-[.72rem]">&copy; {{ date('Y') }} Michael Agbozo</div>
  </div>
</footer>

{{-- FLOATING WHATSAPP BUTTON --}}
<a href="https://wa.me/233248581824?text=Hi%20Michael%2C%20I%20found%20your%20portfolio%20and%20I%27d%20like%20to%20chat!"
   target="_blank" rel="noopener" aria-label="Message me on WhatsApp"
   class="fixed right-5 z-40 w-14 h-14 rounded-full flex items-center justify-center
          bottom-[92px] md:bottom-6
          shadow-[0_8px_30px_rgba(0,0,0,.4)] hover:scale-110 active:scale-95 transition-transform duration-200"
   style="background:#25D366">
  <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff" aria-hidden="true">
    <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm0 18.13h-.01a8.2 8.2 0 0 1-4.18-1.14l-.3-.18-3.12.82.83-3.04-.2-.31a8.22 8.22 0 0 1-1.26-4.37c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.83 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.55-3.7 8.21-8.25 8.21zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.17.25-.64.81-.78.97-.14.17-.29.19-.54.06-.25-.12-1.04-.38-1.99-1.22-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.16-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43-.14-.01-.31-.01-.47-.01-.17 0-.43.06-.66.31-.23.25-.86.84-.86 2.04 0 1.21.88 2.38 1 2.54.12.17 1.74 2.65 4.21 3.72.59.25 1.05.4 1.41.52.59.19 1.13.16 1.55.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.1-.23-.16-.48-.28z"/>
  </svg>
</a>

<script>
  const nav = document.getElementById('nav');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 60) {
      nav.classList.add('bg-bg/95', 'backdrop-blur-md', 'border-border');
    } else {
      nav.classList.remove('bg-bg/95', 'backdrop-blur-md', 'border-border');
    }
  });

  // Light / dark mode toggle (desktop + mobile buttons stay in sync)
  const themeIcons = [
    [document.getElementById('theme-icon-moon'),        document.getElementById('theme-icon-sun')],
    [document.getElementById('theme-icon-moon-mobile'), document.getElementById('theme-icon-sun-mobile')],
  ];
  function syncThemeIcons() {
    const isLight = document.documentElement.classList.contains('light');
    themeIcons.forEach(([moon, sun]) => {
      moon.classList.toggle('hidden', isLight);
      sun.classList.toggle('hidden', !isLight);
    });
  }
  function toggleTheme() {
    document.documentElement.classList.toggle('light');
    localStorage.setItem('theme', document.documentElement.classList.contains('light') ? 'light' : 'dark');
    syncThemeIcons();
  }
  syncThemeIcons();
  document.getElementById('theme-toggle').addEventListener('click', toggleTheme);
  document.getElementById('theme-toggle-mobile').addEventListener('click', toggleTheme);

  const reveals = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('on'); observer.unobserve(e.target); } });
  }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
  reveals.forEach(r => observer.observe(r));
</script>
@stack('scripts')
</body>
</html>
