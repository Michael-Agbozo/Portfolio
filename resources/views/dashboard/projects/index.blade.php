@extends('dashboard.layouts.app')

@section('title', 'Projects')
@section('page-title', 'Projects')
@section('breadcrumb') Projects @endsection

@section('header-actions')
  <a href="{{ route('dashboard.projects.create') }}" class="btn btn-primary btn-sm">+ Add Project</a>
@endsection

@section('content')

<div class="table-wrap">
  <div class="table-head">
    <div class="table-title">All Projects <span style="font-size:.72rem;font-weight:400;color:var(--dim)">({{ $projects->count() }})</span></div>
  </div>

  @if($projects->isEmpty())
    <div class="empty-state">
      <div class="empty-icon">◻</div>
      <div class="empty-title">No projects yet</div>
      <p style="margin-top:.5rem">
        <a href="{{ route('dashboard.projects.create') }}" class="btn btn-primary btn-sm" style="margin-top:.75rem">Add your first project</a>
      </p>
    </div>
  @else
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Category</th>
          <th>Description</th>
          <th>Tags</th>
          <th>URL</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($projects as $project)
        <tr>
          <td style="color:var(--orange);font-size:.72rem;font-family:'Syne',sans-serif;font-weight:700;white-space:nowrap">{{ $project->num }}</td>
          <td class="td-main">{{ $project->title }}</td>
          <td>
            @if($project->category === 'design')
              <span class="tag" style="color:var(--orange);border-color:rgba(232,83,26,.3)">Design</span>
            @else
              <span class="tag" style="color:#60a5fa;border-color:rgba(96,165,250,.3)">Dev</span>
            @endif
          </td>
          <td style="max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $project->meta }}</td>
          <td>
            @foreach($project->tags ?? [] as $tag)
              <span class="tag">{{ $tag }}</span>
            @endforeach
          </td>
          <td>
            @if($project->url)
              <a href="{{ $project->url }}" target="_blank" style="color:var(--orange);font-size:.75rem">↗ link</a>
            @else
              <span style="color:var(--dim)">—</span>
            @endif
          </td>
          <td>
            <form method="POST" action="{{ route('dashboard.projects.toggle-active', $project) }}">
              @csrf @method('PATCH')
              <button type="submit" class="status-toggle {{ $project->active ? 'is-active' : 'is-inactive' }}" title="Click to mark {{ $project->active ? 'inactive' : 'active' }}">
                <span class="dot"></span> {{ $project->active ? 'Active' : 'Inactive' }}
              </button>
            </form>
          </td>
          <td>
            <div class="action-menu" data-action-menu>
              <button type="button" class="action-menu-btn" onclick="toggleActionMenu(this)" aria-label="Actions">⋯</button>
              <div class="action-menu-dropdown">
                <a href="{{ route('project.show', $project) }}" target="_blank" class="action-menu-item">
                  <span class="icon">↗</span> View on site
                </a>
                <a href="{{ route('dashboard.projects.edit', $project) }}" class="action-menu-item">
                  <span class="icon">✎</span> Edit
                </a>
                <form method="POST" action="{{ route('dashboard.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="action-menu-item is-danger">
                    <span class="icon">✕</span> Delete
                  </button>
                </form>
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>

@push('scripts')
<script>
function toggleActionMenu(btn) {
  const menu = btn.closest('[data-action-menu]');
  const wasOpen = menu.classList.contains('is-open');
  document.querySelectorAll('[data-action-menu].is-open').forEach(m => m.classList.remove('is-open'));
  if (!wasOpen) menu.classList.add('is-open');
}

document.addEventListener('click', function (e) {
  if (!e.target.closest('[data-action-menu]')) {
    document.querySelectorAll('[data-action-menu].is-open').forEach(m => m.classList.remove('is-open'));
  }
});
</script>
@endpush

@endsection
