@extends('dashboard.layouts.app')

@section('title', $message->subject)
@section('page-title', 'Message')
@section('breadcrumb')
  <a href="{{ route('dashboard.messages.index') }}">Messages</a>
  <span class="dash-breadcrumb-sep">/</span> {{ Str::limit($message->subject, 40) }}
@endsection

@section('content')

<div class="msg-detail">
  <div class="msg-detail-header">
    <div class="msg-detail-subject">{{ $message->subject }}</div>
    <div class="msg-detail-meta">
      <div class="msg-meta-item">
        <div class="msg-meta-label">From</div>
        <div class="msg-meta-value">{{ $message->name }}</div>
      </div>
      <div class="msg-meta-item">
        <div class="msg-meta-label">Email</div>
        <div class="msg-meta-value">
          <a href="mailto:{{ $message->email }}" style="color:var(--orange)">{{ $message->email }}</a>
        </div>
      </div>
      <div class="msg-meta-item">
        <div class="msg-meta-label">Received</div>
        <div class="msg-meta-value">{{ $message->created_at->format('M j, Y — g:i A') }}</div>
      </div>
      <div class="msg-meta-item">
        <div class="msg-meta-label">Status</div>
        <div class="msg-meta-value" style="color:{{ $message->isUnread() ? 'var(--orange)' : 'var(--dim)' }}">
          {{ $message->isUnread() ? 'Unread' : 'Read' }}
        </div>
      </div>
    </div>
  </div>

  <div class="msg-detail-body">{{ $message->message }}</div>

  <div class="msg-detail-actions">
    <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" class="btn btn-primary">Reply via Email</a>
    <a href="{{ route('dashboard.messages.index') }}" class="btn btn-secondary">← Back</a>
    <form method="POST" action="{{ route('dashboard.messages.destroy', $message) }}" onsubmit="return confirmDelete(event, this, 'This message will be permanently removed from your inbox.', 'Delete this message?')" style="margin-left:auto">
      @csrf @method('DELETE')
      <button class="btn btn-danger" type="submit">Delete</button>
    </form>
  </div>
</div>

@endsection
