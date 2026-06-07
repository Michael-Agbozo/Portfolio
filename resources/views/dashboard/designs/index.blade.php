@extends('dashboard.layouts.app')

@section('title', 'Designs')
@section('page-title', 'Designs')
@section('breadcrumb') Designs @endsection

@section('header-actions')
  <a href="{{ route('dashboard.designs.create') }}" class="btn btn-primary btn-sm">+ Add Design</a>
@endsection

@section('content')

<div class="card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem">
    <div class="card-title" style="margin-bottom:0">Gallery <span style="font-size:.72rem;font-weight:400;color:var(--dim)">({{ $designs->count() }} items)</span></div>
  </div>

  @if($designs->isEmpty())
    <div class="empty-state">
      <div class="empty-icon">◈</div>
      <div class="empty-title">No designs yet</div>
      <p style="margin-top:.75rem">
        <a href="{{ route('dashboard.designs.create') }}" class="btn btn-primary btn-sm">Add your first design</a>
      </p>
    </div>
  @else
    <div class="design-grid-mgmt">
      @foreach($designs as $design)
      <div class="design-mgmt-item">
        <a href="{{ route('dashboard.designs.show', $design) }}">
          <img src="{{ $design->src }}" alt="{{ $design->alt }}" loading="lazy"/>
        </a>
        <div class="design-item-actions">
          <a href="{{ route('dashboard.designs.show', $design) }}" class="btn btn-ghost btn-sm" title="View">View</a>
          <a href="{{ route('dashboard.designs.edit', $design) }}" class="btn btn-secondary btn-sm">Edit</a>
          <form method="POST" action="{{ route('dashboard.designs.destroy', $design) }}" onsubmit="return confirmDelete(event, this, 'This design and its image will be permanently removed.', 'Delete this design?')" style="margin:0">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
          </form>
        </div>
        <div class="design-item-alt">{{ $design->alt ?: '—' }}</div>
      </div>
      @endforeach
    </div>
  @endif
</div>

@endsection
