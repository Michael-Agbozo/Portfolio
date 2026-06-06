@extends('dashboard.layouts.app')

@section('title', 'Messages')
@section('page-title', 'Messages')
@section('breadcrumb') Messages @endsection

@section('content')

@if($messages->isEmpty())
  <div class="empty-state">
    <div class="empty-icon">✉</div>
    <div class="empty-title">No messages yet</div>
    <p>Messages submitted through the contact form will appear here.</p>
  </div>
@else
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.1rem">
    <div style="font-size:.78rem;color:var(--dim)">
      {{ $messages->count() }} message{{ $messages->count() !== 1 ? 's' : '' }} total
      @php $unread = $messages->where('read_at', null)->count() @endphp
      @if($unread > 0) &nbsp;·&nbsp; <span style="color:var(--orange)">{{ $unread }} unread</span> @endif
    </div>
  </div>

  <div class="msg-list">
    @foreach($messages as $msg)
    <a href="{{ route('dashboard.messages.show', $msg) }}" class="msg-item {{ $msg->isUnread() ? 'unread' : '' }}">
      <div class="msg-dot"></div>
      <div class="msg-body">
        <div class="msg-from">
          {{ $msg->name }}
          <span class="msg-from-email">{{ $msg->email }}</span>
        </div>
        <div class="msg-subject">{{ $msg->subject }}</div>
        <div class="msg-preview">{{ Str::limit($msg->message, 80) }}</div>
      </div>
      <div class="msg-meta">
        <div class="msg-time">{{ $msg->created_at->format('M j') }}</div>
        @if($msg->isUnread())
          <div class="msg-unread-badge">New</div>
        @endif
      </div>
    </a>
    @endforeach
  </div>
@endif

@endsection
