<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>@yield('title', 'Dashboard') — Michael Agbozo</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"/>
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}"/>
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
      <a href="{{ route('dashboard.profile.show') }}" class="sidebar-link {{ request()->routeIs('dashboard.profile.*', 'dashboard.security.*', 'dashboard.cv.*') ? 'active' : '' }}">
        <span class="s-icon">⚙</span> Settings
      </a>
      <a href="{{ route('dashboard.logs.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.logs.*') ? 'active' : '' }}">
        <span class="s-icon">⚠</span> Error Logs
      </a>

      <div class="sidebar-section">Site</div>
      <a href="/" target="_blank" rel="noopener" class="sidebar-link">
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

<div id="file-size-overlay" class="confirm-overlay">
  <div class="confirm-box">
    <div class="confirm-icon">!</div>
    <div class="confirm-title">File too large</div>
    <p class="confirm-message" id="file-size-message">
      This file is too large to upload. Please make it smaller and try again.
    </p>
    <div class="confirm-actions">
      <button type="button" class="btn btn-primary btn-sm" onclick="closeFileSizeModal()">OK</button>
    </div>
  </div>
</div>

{{-- File manager modal: shown when multiple files are selected and the total is too large.
     Lets the user remove individual files until the total is within the limit. --}}
<div id="file-manager-overlay" class="confirm-overlay">
  <div class="confirm-box" style="max-width:520px;width:calc(100% - 2rem)">
    <div class="confirm-icon">!</div>
    <div class="confirm-title">Files too large</div>
    <p class="confirm-message" id="fm-desc"></p>
    <div id="fm-list" style="max-height:260px;overflow-y:auto;margin:.75rem 0;border-top:1px solid var(--line)"></div>
    <div id="fm-total" style="font-size:.8rem;font-weight:600;margin-bottom:1.1rem;text-align:right"></div>
    <div class="confirm-actions">
      <button type="button" class="btn btn-secondary btn-sm" onclick="cancelFileManager()">Cancel</button>
      <button type="button" class="btn btn-primary btn-sm" id="fm-confirm" onclick="confirmFileManager()">Upload selected</button>
    </div>
  </div>
</div>

<script>
  const maxFileBytes  = 50 * 1024 * 1024;
  const maxTotalBytes = 60 * 1024 * 1024;

  function formatFileSize(bytes) {
    return (bytes / 1024 / 1024).toFixed(1).replace(/\.0$/, '') + ' MB';
  }

  // ── Simple single-file error modal ──────────────────────────────────────────
  function showFileSizeModal(message) {
    document.getElementById('file-size-message').textContent = message;
    document.getElementById('file-size-overlay').classList.add('is-open');
  }
  function closeFileSizeModal() {
    document.getElementById('file-size-overlay').classList.remove('is-open');
  }

  // ── File-manager modal ──────────────────────────────────────────────────────
  // Lets the user remove individual files from a multi-file selection until
  // the total is within the 60 MB limit, then uploads the remaining ones.
  let fmState = null;

  function openFileManager(input, form, files) {
    fmState = {
      input,
      form,
      entries: files.map(function (f) { return { file: f, keep: true }; })
    };
    renderFileManager();
    document.getElementById('file-manager-overlay').classList.add('is-open');
  }

  function renderFileManager() {
    var entries  = fmState.entries;
    var kept     = entries.filter(function (e) { return e.keep; });
    var total    = kept.reduce(function (s, e) { return s + e.file.size; }, 0);
    var overTotal  = total > maxTotalBytes;
    var hasPerFile = kept.some(function (e) { return e.file.size > maxFileBytes; });
    var canUpload  = !overTotal && !hasPerFile && kept.length > 0;

    document.getElementById('fm-desc').textContent =
      'Your files are ' + formatFileSize(total) + ' total — over the 60 MB upload limit. ' +
      'Click Remove next to files you want to leave out, then click Upload.';

    var list = document.getElementById('fm-list');
    list.innerHTML = '';

    entries.forEach(function (entry, i) {
      var overFile = entry.file.size > maxFileBytes;

      var row = document.createElement('div');
      row.style.cssText = 'display:flex;align-items:center;gap:.75rem;padding:.45rem 0;' +
        'border-bottom:1px solid var(--line);opacity:' + (entry.keep ? '1' : '.4');

      var info = document.createElement('div');
      info.style.cssText = 'flex:1;min-width:0';

      var name = document.createElement('div');
      name.style.cssText = 'font-size:.8rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;' +
        (entry.keep ? '' : 'text-decoration:line-through;color:var(--dim)');
      name.textContent = entry.file.name;
      name.title = entry.file.name;

      var meta = document.createElement('div');
      meta.style.cssText = 'font-size:.7rem;color:' +
        (overFile && entry.keep ? '#e55' : 'var(--dim)');
      meta.textContent = formatFileSize(entry.file.size) +
        (overFile ? ' — over 50 MB limit' : '');

      info.appendChild(name);
      info.appendChild(meta);

      var btn = document.createElement('button');
      btn.type = 'button';
      btn.style.cssText = 'flex-shrink:0;padding:.2rem .6rem;font-size:.72rem;border-radius:4px;' +
        'border:1px solid var(--line);background:var(--bg2);color:var(--fg);cursor:pointer';
      btn.textContent = entry.keep ? 'Remove' : 'Keep';
      btn.onclick = (function (idx) {
        return function () {
          fmState.entries[idx].keep = !fmState.entries[idx].keep;
          renderFileManager();
        };
      })(i);

      row.appendChild(info);
      row.appendChild(btn);
      list.appendChild(row);
    });

    var totalEl = document.getElementById('fm-total');
    totalEl.textContent = 'Total: ' + formatFileSize(total) + ' / 60 MB';
    totalEl.style.color = (overTotal || hasPerFile) ? '#e55' : '#4a4';

    document.getElementById('fm-confirm').disabled = !canUpload;
  }

  function cancelFileManager() {
    if (fmState) fmState.input.value = '';
    fmState = null;
    document.getElementById('file-manager-overlay').classList.remove('is-open');
  }

  function confirmFileManager() {
    var input   = fmState.input;
    var form    = fmState.form;
    var entries = fmState.entries;
    var dt = new DataTransfer();
    entries.filter(function (e) { return e.keep; })
           .forEach(function (e) { dt.items.add(e.file); });
    input.files = dt.files;
    fmState = null;
    document.getElementById('file-manager-overlay').classList.remove('is-open');
    if (form) {
      delete form.dataset.submitGuarded;
      form.requestSubmit();
    }
  }

  // ── Size-check helper ───────────────────────────────────────────────────────
  function hasFileSizeError(fileArrays) {
    var total = 0;
    for (var ai = 0; ai < fileArrays.length; ai++) {
      var files = fileArrays[ai];
      for (var fi = 0; fi < files.length; fi++) {
        if (files[fi].size > maxFileBytes) return true;
        total += files[fi].size;
      }
    }
    return total > maxTotalBytes;
  }

  // ── Event listeners ─────────────────────────────────────────────────────────
  document.addEventListener('change', function (e) {
    var input = e.target;
    if (!(input instanceof HTMLInputElement) || input.type !== 'file') return;
    var files = Array.from(input.files || []);
    if (!files.length || !hasFileSizeError([files])) return;

    e.preventDefault();
    e.stopImmediatePropagation();

    if (files.length > 1) {
      openFileManager(input, null, files);
    } else {
      input.value = '';
      showFileSizeModal('"' + files[0].name + '" is ' + formatFileSize(files[0].size) +
        '. The limit is 50 MB per file. Please choose a smaller file and try again.');
    }
  }, true);

  // Stop double-clicking Save/Upload/Delete from sending the same request twice.
  document.addEventListener('submit', function (e) {
    var form   = e.target;
    var inputs = Array.from(form.querySelectorAll('input[type="file"]'));

    if (hasFileSizeError(inputs.map(function (i) { return i.files || []; }))) {
      e.preventDefault();
      var multiInput = inputs.find(function (i) {
        return i.multiple && Array.from(i.files || []).length > 1;
      });
      if (multiInput) {
        openFileManager(multiInput, form, Array.from(multiInput.files));
      } else {
        for (var ii = 0; ii < inputs.length; ii++) {
          var bad = Array.from(inputs[ii].files || []).find(function (f) { return f.size > maxFileBytes; });
          if (bad) {
            inputs[ii].value = '';
            showFileSizeModal('"' + bad.name + '" is ' + formatFileSize(bad.size) +
              '. The limit is 50 MB per file. Please choose a smaller file and try again.');
            break;
          }
        }
      }
      return;
    }

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

  // Mobile sidebar drawer — open/close via hamburger, backdrop, or nav link.
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

  // Light / dark mode toggle.
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

  document.getElementById('file-size-overlay').addEventListener('click', function (e) {
    if (e.target.id === 'file-size-overlay') closeFileSizeModal();
  });
  document.getElementById('file-manager-overlay').addEventListener('click', function (e) {
    if (e.target.id === 'file-manager-overlay') cancelFileManager();
  });
</script>

<script>
  async function instantUpload(file) {
    const data = new FormData();
    data.append('file', file);
    data.append('_token', '{{ csrf_token() }}');
    const res = await fetch('/dashboard/upload-temp', { method: 'POST', body: data });
    if (!res.ok) {
      const body = await res.json().catch(() => ({}));
      throw new Error(body.errors?.file?.[0] ?? 'Upload failed');
    }
    return (await res.json()).path;
  }
</script>

@stack('scripts')
</body>
</html>
