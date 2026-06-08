<div class="settings-tabs">
  <a href="{{ route('dashboard.profile.show') }}" class="settings-tab {{ request()->routeIs('dashboard.profile.*') ? 'active' : '' }}">
    <span>◌</span> Profile
  </a>
  <a href="{{ route('dashboard.security.index') }}" class="settings-tab {{ request()->routeIs('dashboard.security.*') ? 'active' : '' }}">
    <span>🔒</span> Security
  </a>
</div>
