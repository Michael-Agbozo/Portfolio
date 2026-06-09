@extends('dashboard.layouts.app')

@section('title', 'Overview')
@section('page-title', 'Overview')

@section('header-actions')
  <a href="{{ route('dashboard.projects.create') }}" class="btn btn-primary btn-sm">+ New Project</a>
@endsection

@section('content')

<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-label">Projects</div>
    <div class="stat-num">{{ $stats['projects'] }}<span>.</span></div>
    <div class="stat-sub">In portfolio</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Designs</div>
    <div class="stat-num">{{ $stats['designs'] }}<span>.</span></div>
    <div class="stat-sub">In gallery</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Messages</div>
    <div class="stat-num">{{ $stats['messages'] }}<span>.</span></div>
    <div class="stat-sub">Total received</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Unread</div>
    <div class="stat-num">{{ $stats['unread'] }}<span>.</span></div>
    <div class="stat-sub">Need attention</div>
  </div>
</div>

<div class="overview-grid">

  <!-- Recent Messages -->
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.1rem">
      <div class="card-title" style="margin-bottom:0">Recent Messages</div>
      <a href="{{ route('dashboard.messages.index') }}" class="btn btn-secondary btn-sm">View all</a>
    </div>
    @if($recentMessages->isEmpty())
      <div class="empty-state" style="padding:2rem">
        <div class="empty-icon">✉</div>
        <div class="empty-title">No messages yet</div>
      </div>
    @else
      <div style="display:flex;flex-direction:column;gap:1px;border:1px solid var(--line);border-radius:8px;overflow:hidden">
        @foreach($recentMessages as $msg)
        <a href="{{ route('dashboard.messages.show', $msg) }}" style="display:grid;grid-template-columns:8px 1fr;gap:.75rem;padding:.85rem 1rem;background:{{ $msg->isUnread() ? 'rgba(232,83,26,.04)' : 'var(--bg3)' }};transition:background .15s;border-bottom:1px solid var(--line)">
          <span style="width:7px;height:7px;border-radius:50%;background:{{ $msg->isUnread() ? 'var(--orange)' : 'var(--line)' }};margin-top:.35rem;flex-shrink:0"></span>
          <div>
            <div style="font-size:.8rem;font-weight:600;color:var(--white)">{{ $msg->name }} <span style="font-size:.7rem;font-weight:400;color:var(--dim)">{{ $msg->email }}</span></div>
            <div style="font-size:.75rem;color:var(--muted);margin-top:.1rem">{{ Str::limit($msg->subject, 55) }}</div>
            <div style="font-size:.68rem;color:var(--dim);margin-top:.2rem">{{ $msg->created_at->diffForHumans() }}</div>
          </div>
        </a>
        @endforeach
      </div>
    @endif
  </div>

  <!-- Quick Links -->
  <div class="card">
    <div class="card-title">Quick Actions</div>
    <div style="display:flex;flex-direction:column;gap:.6rem">
      <a href="{{ route('dashboard.projects.create') }}" style="display:flex;align-items:center;gap:.85rem;padding:1rem 1.1rem;background:var(--bg3);border:1px solid var(--line);border-radius:8px;transition:border-color .15s" onmouseover="this.style.borderColor='var(--orange)'" onmouseout="this.style.borderColor='var(--line)'">
        <span style="font-size:1.1rem;opacity:.7">◻</span>
        <div>
          <div style="font-size:.82rem;font-weight:600;color:var(--white)">Add Project</div>
          <div style="font-size:.72rem;color:var(--dim)">Add a new portfolio item</div>
        </div>
      </a>
      <a href="{{ route('dashboard.designs.create') }}" style="display:flex;align-items:center;gap:.85rem;padding:1rem 1.1rem;background:var(--bg3);border:1px solid var(--line);border-radius:8px;transition:border-color .15s" onmouseover="this.style.borderColor='var(--orange)'" onmouseout="this.style.borderColor='var(--line)'">
        <span style="font-size:1.1rem;opacity:.7">◈</span>
        <div>
          <div style="font-size:.82rem;font-weight:600;color:var(--white)">Add Design</div>
          <div style="font-size:.72rem;color:var(--dim)">Upload a social media design</div>
        </div>
      </a>
      <a href="{{ route('dashboard.messages.index') }}" style="display:flex;align-items:center;gap:.85rem;padding:1rem 1.1rem;background:var(--bg3);border:1px solid var(--line);border-radius:8px;transition:border-color .15s" onmouseover="this.style.borderColor='var(--orange)'" onmouseout="this.style.borderColor='var(--line)'">
        <span style="font-size:1.1rem;opacity:.7">✉</span>
        <div>
          <div style="font-size:.82rem;font-weight:600;color:var(--white)">View Inbox <span style="color:var(--orange)">@if($stats['unread'] > 0)({{ $stats['unread'] }} unread)@endif</span></div>
          <div style="font-size:.72rem;color:var(--dim)">Read contact form messages</div>
        </div>
      </a>
      <a href="/" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:.85rem;padding:1rem 1.1rem;background:var(--bg3);border:1px solid var(--line);border-radius:8px;transition:border-color .15s" onmouseover="this.style.borderColor='var(--orange)'" onmouseout="this.style.borderColor='var(--line)'">
        <span style="font-size:1.1rem;opacity:.7">↗</span>
        <div>
          <div style="font-size:.82rem;font-weight:600;color:var(--white)">View Live Site</div>
          <div style="font-size:.72rem;color:var(--dim)">See how your portfolio looks</div>
        </div>
      </a>
    </div>
  </div>

</div>

@endsection
