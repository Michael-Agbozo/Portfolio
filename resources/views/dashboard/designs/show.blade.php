@extends('dashboard.layouts.app')

@section('title', $design->alt ?: 'Design')
@section('page-title', 'View Design')
@section('breadcrumb')
  <a href="{{ route('dashboard.designs.index') }}">Designs</a>
  <span class="dash-breadcrumb-sep">/</span> {{ $design->alt ?: 'Design #' . $design->id }}
@endsection

@section('header-actions')
  <a href="{{ route('dashboard.designs.edit', $design) }}" class="btn btn-primary btn-sm">Edit</a>
@endsection

@section('content')

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">

  {{-- Image --}}
  <div style="background:var(--bg2);border:1px solid var(--line);border-radius:12px;overflow:hidden">
    <img src="{{ $design->src }}" alt="{{ $design->alt }}" style="width:100%;display:block;max-height:70vh;object-fit:contain;background:var(--bg3)"/>
  </div>

  {{-- Details --}}
  <div style="display:flex;flex-direction:column;gap:1rem">

    <div class="card">
      <div class="card-title">Details</div>
      <div style="display:flex;flex-direction:column;gap:.75rem">
        <div>
          <div style="font-size:.6rem;color:var(--dim);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.25rem">Alt Text</div>
          <div style="font-size:.85rem;color:var(--white)">{{ $design->alt ?: '—' }}</div>
        </div>
        <div>
          <div style="font-size:.6rem;color:var(--dim);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.25rem">Source</div>
          <div style="font-size:.72rem;color:var(--muted);word-break:break-all">{{ $design->src }}</div>
        </div>
        <div>
          <div style="font-size:.6rem;color:var(--dim);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.25rem">Added</div>
          <div style="font-size:.85rem;color:var(--muted)">{{ $design->created_at->format('M j, Y') }}</div>
        </div>
      </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:.5rem">
      <a href="{{ route('dashboard.designs.edit', $design) }}" class="btn btn-primary" style="justify-content:center">Edit Design</a>
      <a href="{{ $design->src }}" target="_blank" rel="noopener" class="btn btn-secondary" style="justify-content:center">Open Full Image ↗</a>
      <form method="POST" action="{{ route('dashboard.designs.destroy', $design) }}" onsubmit="return confirmDelete(event, this, 'This design and its image will be permanently removed.', 'Delete this design?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger" type="submit" style="width:100%;justify-content:center">Delete</button>
      </form>
    </div>

  </div>
</div>

@endsection
