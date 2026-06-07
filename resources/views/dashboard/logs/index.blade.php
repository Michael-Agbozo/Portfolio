@extends('dashboard.layouts.app')

@section('title', 'Error Logs')
@section('page-title', 'Error Logs')
@section('breadcrumb') Error Logs @endsection

@section('content')

@if(empty($entries))
  <div class="empty-state">
    <div class="empty-icon">⚠</div>
    <div class="empty-title">No log entries</div>
    <p>Nothing has been logged yet — that's a good sign. Errors and warnings from the site will show up here.</p>
  </div>
@else
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.1rem;flex-wrap:wrap;gap:.6rem">
    <div style="font-size:.78rem;color:var(--dim)">
      Showing {{ count($entries) }} most recent {{ count($entries) === 1 ? 'entry' : 'entries' }}
      &nbsp;·&nbsp; log file size: {{ number_format($size / 1024, 1) }} KB
      @if($truncated) &nbsp;·&nbsp; <span style="color:var(--orange)">older entries are not shown</span> @endif
    </div>

    <form method="POST" action="{{ route('dashboard.logs.clear') }}" onsubmit="return confirmDelete(event, this, 'This will permanently erase the entire log file. This cannot be undone.', 'Clear all log entries?')">
      @csrf @method('DELETE')
      <button class="btn btn-secondary btn-sm" type="submit">Clear log file</button>
    </form>
  </div>

  <div class="log-list">
    @foreach($entries as $i => $entry)
    <div class="log-item">
      <button type="button" class="log-summary" onclick="document.getElementById('log-{{ $i }}').classList.toggle('is-open')">
        <span class="log-level log-level-{{ strtolower($entry['level']) }}">{{ $entry['level'] }}</span>
        <span class="log-time">{{ $entry['time'] }}</span>
        <span class="log-message">{{ Str::limit($entry['message'], 140) }}</span>
      </button>
      <pre id="log-{{ $i }}" class="log-detail">{{ $entry['full'] }}</pre>
    </div>
    @endforeach
  </div>
@endif

@endsection
