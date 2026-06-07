@extends('layouts.app')
@section('title', $project->title . ' — Michael Agbozo')
@section('content')

<div class="max-w-[800px] mx-auto px-8 pt-32 pb-20">

  <a href="/#work" class="text-muted text-[.75rem] uppercase tracking-widest hover:text-orange transition-colors">← Back to Portfolio</a>

  @if($project->feature_image)
    <div class="mt-8 rounded-2xl overflow-hidden border border-border">
      <img src="{{ $project->feature_image }}" alt="{{ $project->title }}" loading="lazy"
           class="w-full h-auto block"/>
    </div>
  @endif

  <div class="mt-10 pb-10 border-b border-border">
    <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-4">
      <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> Project
    </div>
    <div class="font-display text-[.72rem] text-orange uppercase tracking-[.15em] mt-4 mb-3">{{ $project->num }}</div>
    <h1 class="font-display font-extrabold text-white leading-tight mb-5"
        style="font-size:clamp(2.4rem,5vw,3.8rem)">{{ $project->title }}</h1>
    @if($project->meta)
      <p class="text-muted text-[1rem] leading-[1.75] mb-6">{{ $project->meta }}</p>
    @endif
    @if($project->tags)
      <div class="flex gap-2 flex-wrap">
        @foreach($project->tags as $tag)
          <span class="text-[.7rem] border border-border text-muted px-3 py-1 rounded">{{ $tag }}</span>
        @endforeach
      </div>
    @endif
  </div>

  <div class="py-10 border-b border-border space-y-6">
    @if($project->body)
      @foreach(array_filter(explode("\n\n", $project->body)) as $paragraph)
        <p class="text-[.96rem] text-muted leading-[2]">{{ $paragraph }}</p>
      @endforeach
    @else
      <p class="text-dim italic text-[.96rem]">No detailed write-up yet — check back soon.</p>
    @endif
  </div>

  @if($project->images && count($project->images))
  <div class="columns-2 gap-4 pt-10 border-t border-border mb-12">
    @foreach($project->images as $img)
      <div class="break-inside-avoid mb-4 rounded-lg overflow-hidden border border-border">
        <img src="{{ $img }}" alt="{{ $project->title }} — work sample" loading="lazy"
             class="w-full h-auto block hover:scale-[1.03] transition-transform duration-500"/>
      </div>
    @endforeach
  </div>
  @endif

  <div class="flex gap-4 items-center flex-wrap pt-10">
    @if($project->url)
      <a href="{{ $project->url }}" target="_blank" rel="noopener"
         class="bg-orange text-white px-7 py-3 rounded-full text-[.85rem] font-semibold hover:bg-orange2 transition-colors">
        View Live Project ↗
      </a>
    @endif
    <a href="/#work"
       class="border border-border text-muted px-7 py-3 rounded-full text-[.85rem] hover:border-white hover:text-white transition-all">
      ← Back to Portfolio
    </a>
  </div>

</div>

@endsection
