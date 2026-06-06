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
          <th>Description</th>
          <th>Tags</th>
          <th>URL</th>
          <th>Order</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($projects as $project)
        <tr>
          <td style="color:var(--orange);font-size:.72rem;font-family:'Syne',sans-serif;font-weight:700;white-space:nowrap">{{ $project->num }}</td>
          <td class="td-main">{{ $project->title }}</td>
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
          <td>{{ $project->sort_order }}</td>
          <td>
            <div class="td-actions">
              <a href="{{ route('dashboard.projects.edit', $project) }}" class="btn btn-secondary btn-sm">Edit</a>
              <form method="POST" action="{{ route('dashboard.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>

@endsection
