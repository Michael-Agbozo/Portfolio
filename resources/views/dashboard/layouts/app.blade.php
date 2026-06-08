<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>@yield('title', 'Dashboard') — Michael Agbozo</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
{{-- Paint the correct background immediately, before the stylesheet finishes
     loading — otherwise the browser shows a flash of the wrong colour on
     every dashboard page load/refresh. --}}
<style>html,body{background:#0c0c0c}html.light,html.light body{background:#fff}</style>
<script>
  if (localStorage.getItem('dashboard-theme') === 'light') {
    document.documentElement.classList.add('light');
  }
</script>
@vite(['resources/css/dashboard.css'])
@stack('head')
</head>
<body>
<div class="dash-wrap">

  <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
      Michael<span>.</span>
      <small>Admin Panel</small>
    </div>

    <nav class="sidebar-nav">
      <div class="sidebar-section">Main</div>
      <a href="{{ route('dashboard.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <span class="s-icon">◈</span> Overview
      </a>

      <div class="sidebar-section">Content</div>
      <a href="{{ route('dashboard.projects.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.projects.*') ? 'active' : '' }}">
        <span class="s-icon">◻</span> Projects
      </a>
      <a href="{{ route('dashboard.designs.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.designs.*') ? 'active' : '' }}">
        <span class="s-icon">◈</span> Designs
      </a>

      <a href="{{ route('dashboard.media.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.media.*') ? 'active' : '' }}">
        <span class="s-icon">◨</span> Media
      </a>

      <div class="sidebar-section">Inbox</div>
      <a href="{{ route('dashboard.messages.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.messages.*') ? 'active' : '' }}">
        <span class="s-icon">✉</span> Messages
        @if($unreadCount > 0)
          <span class="sidebar-badge">{{ $unreadCount }}</span>
        @endif
      </a>

      <div class="sidebar-section">System</div>
      <a href="{{ route('dashboard.profile.show') }}" class="sidebar-link {{ request()->routeIs('dashboard.profile.*') ? 'active' : '' }}">
        <span class="s-icon">◌</span> Profile
      </a>
      <a href="{{ route('dashboard.security.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.security.*') ? 'active' : '' }}">
        <span class="s-icon">🔒</span> Security
      </a>
      <a href="{{ route('dashboard.logs.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.logs.*') ? 'active' : '' }}">
        <span class="s-icon">⚠</span> Error Logs
      </a>

      <div class="sidebar-section">Site</div>
      <a href="/" target="_blank" class="sidebar-link">
        <span class="s-icon">↗</span> View Site
      </a>
    </nav>

    <div class="sidebar-footer">
      <div class="sidebar-user">
        @if(auth()->user()->avatarUrl())
          <img src="{{ auth()->user()->avatarUrl() }}" alt="{{ auth()->user()->name }}" class="sidebar-avatar" style="object-fit:cover"/>
        @else
          <div class="sidebar-avatar">{{ auth()->user()->initials() }}</div>
        @endif
        <div>
          <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
          <div class="sidebar-user-role">Administrator</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin-left:auto">
          @csrf
          <button type="submit" class="sidebar-logout" title="Sign out">⏻</button>
        </form>
      </div>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="dash-main">
    <header class="dash-header">
      <button type="button" class="dash-menu-btn dash-icon-btn" id="sidebar-toggle" aria-label="Open menu">☰</button>
      <div class="dash-header-left">
        <div class="dash-page-title">@yield('page-title', 'Dashboard')</div>
        @hasSection('breadcrumb')
        <div class="dash-breadcrumb">
          <a href="{{ route('dashboard.index') }}">Home</a>
          <span class="dash-breadcrumb-sep">/</span>
          @yield('breadcrumb')
        </div>
        @endif
      </div>
      <div class="dash-header-actions">
        @yield('header-actions')
        <button type="button" class="dash-icon-btn" id="theme-toggle" aria-label="Toggle light/dark mode" title="Toggle light/dark mode">
          <span id="theme-icon-moon">🌙</span>
          <span id="theme-icon-sun" style="display:none">☀</span>
        </button>
      </div>
    </header>

    <div class="dash-content">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @yield('content')
    </div>
  </div>

</div>

@include('dashboard.partials._confirm-modal')

<script>
  // Stop double-clicking Save/Upload/Delete from sending the same request twice
  // (e.g. uploading the same photo to a project two times).
  document.addEventListener('submit', function (e) {
    const form = e.target;

    // A confirm-modal form fires submit once (prevented, to show the dialog) and
    // again when actually confirmed — only guard the real, un-prevented attempt.
    if (e.defaultPrevented) return;

    if (form.dataset.submitGuarded === 'done') {
      e.preventDefault();
      return;
    }
    form.dataset.submitGuarded = 'done';

    form.querySelectorAll('button[type="submit"]').forEach(function (btn) {
      btn.disabled = true;
      btn.dataset.originalText = btn.textContent;
      btn.textContent = btn.dataset.busyText || 'Please wait…';
    });
  });

  // Mobile sidebar drawer — open/close via the hamburger button, the backdrop, or by
  // picking a link (so the menu doesn't stay open after navigating on a small screen).
  (function () {
    const sidebar  = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');
    const toggle   = document.getElementById('sidebar-toggle');

    function closeSidebar() {
      sidebar.classList.remove('is-open');
      backdrop.classList.remove('is-open');
    }
    function openSidebar() {
      sidebar.classList.add('is-open');
      backdrop.classList.add('is-open');
    }

    toggle.addEventListener('click', function () {
      sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
    });
    backdrop.addEventListener('click', closeSidebar);
    sidebar.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', closeSidebar);
    });
  })();

  // Light / dark mode toggle — mirrors the public site's toggle, stored separately
  // so visitors and the admin can each have their own preference.
  (function () {
    const root = document.documentElement;
    const moon = document.getElementById('theme-icon-moon');
    const sun  = document.getElementById('theme-icon-sun');

    function syncIcons() {
      const isLight = root.classList.contains('light');
      moon.style.display = isLight ? 'none' : '';
      sun.style.display  = isLight ? '' : 'none';
    }
    document.getElementById('theme-toggle').addEventListener('click', function () {
      root.classList.toggle('light');
      localStorage.setItem('dashboard-theme', root.classList.contains('light') ? 'light' : 'dark');
      syncIcons();
    });
    syncIcons();
  })();
</script>

@stack('scripts')
</body>
</html>
