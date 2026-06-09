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
          <td data-label="#" style="color:var(--orange);font-size:.72rem;font-family:'Syne',sans-serif;font-weight:700;white-space:nowrap">{{ $project->num }}</td>
          <td data-label="Title" class="td-main">{{ $project->title }}</td>
          <td data-label="Category">
            @if($project->category === 'design')
              <span class="tag" style="color:var(--orange);border-color:rgba(232,83,26,.3)">Design</span>
            @else
              <span class="tag" style="color:#60a5fa;border-color:rgba(96,165,250,.3)">Dev</span>
            @endif
          </td>
          <td data-label="Description" class="td-truncate">{{ $project->meta }}</td>
          <td data-label="Tags">
            <span class="td-tags">
              @foreach($project->tags ?? [] as $tag)
                <span class="tag">{{ $tag }}</span>
              @endforeach
            </span>
          </td>
          <td data-label="URL">
            @if($project->url)
              <a href="{{ $project->url }}" target="_blank" rel="noopener" style="color:var(--orange);font-size:.75rem">↗ link</a>
            @else
              <span style="color:var(--dim)">—</span>
            @endif
          </td>
          <td data-label="Status">
            <form method="POST" action="{{ route('dashboard.projects.toggle-active', $project) }}">
              @csrf @method('PATCH')
              <button type="submit" class="status-toggle {{ $project->active ? 'is-active' : 'is-inactive' }}" title="Click to mark {{ $project->active ? 'inactive' : 'active' }}">
                <span class="dot"></span> {{ $project->active ? 'Active' : 'Inactive' }}
              </button>
            </form>
          </td>
          <td data-label="">
            <div class="action-menu" data-action-menu>
              <button type="button" class="action-menu-btn" onclick="toggleActionMenu(this)" aria-label="Actions">⋯</button>
              <div class="action-menu-dropdown">
                <a href="{{ route('project.show', $project) }}" target="_blank" rel="noopener" class="action-menu-item">
                  <span class="icon">↗</span> View on site
                </a>
                <a href="{{ route('dashboard.projects.edit', $project) }}" class="action-menu-item">
                  <span class="icon">✎</span> Edit
                </a>
                <form method="POST" action="{{ route('dashboard.projects.destroy', $project) }}" onsubmit="return confirmDelete(event, this, 'This project and its images will be permanently removed.', 'Delete this project?')">
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
function closeActionMenus() {
  document.querySelectorAll('[data-action-menu].is-open').forEach(m => m.classList.remove('is-open'));
}

function toggleActionMenu(btn) {
  const menu = btn.closest('[data-action-menu]');
  const dropdown = menu.querySelector('.action-menu-dropdown');
  const wasOpen = menu.classList.contains('is-open');

  closeActionMenus();
  if (wasOpen) return;

  menu.classList.add('is-open');

  // Position the menu relative to the button itself (not the table row),
  // so it floats above the table instead of overlapping the rows below it.
  const rect = btn.getBoundingClientRect();
  const dropdownHeight = dropdown.offsetHeight;
  const opensUpward = (window.innerHeight - rect.bottom) < (dropdownHeight + 12) && rect.top > dropdownHeight;

  dropdown.style.top = opensUpward
    ? (rect.top - dropdownHeight - 6) + 'px'
    : (rect.bottom + 6) + 'px';
  dropdown.style.right = (window.innerWidth - rect.right) + 'px';
  dropdown.style.left = 'auto';
}

document.addEventListener('click', function (e) {
  if (!e.target.closest('[data-action-menu]')) closeActionMenus();
});
window.addEventListener('scroll', closeActionMenus, true);
window.addEventListener('resize', closeActionMenus);
</script>
@endpush

@endsection
