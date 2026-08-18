@extends('layouts.app')
@php
  $projectDescription = \Illuminate\Support\Str::limit(
      trim(strip_tags($project->meta ?: $project->body ?: 'A selected web development, design, or systems project by Michael Agbozo.')),
      155,
      ''
  );
  $projectImage = $project->feature_image ?: ($project->images[0] ?? asset('images/michael-hero.png'));
  $projectImage = \Illuminate\Support\Str::startsWith($projectImage, ['http://', 'https://'])
      ? $projectImage
      : url($projectImage);
  $quickFacts = array_filter([
      'Client' => $project->client_name,
      'Year' => $project->project_year,
      'Services' => $project->services ? implode(', ', $project->services) : null,
      'Tech Stack' => $project->tech_stack ? implode(', ', $project->tech_stack) : null,
  ]);
  $caseStudySections = array_filter([
      'The Challenge' => $project->challenge,
      'The Solution' => $project->solution,
      'Results / Outcome' => $project->results,
  ]);
  $hasBeforeAfter = $project->before_image || $project->after_image;
@endphp
@section('title', $project->title . ' — Michael Agbozo')
@section('meta_description', $projectDescription)
@section('canonical', route('project.show', $project))
@section('og_type', 'article')
@section('og_image', $projectImage)
@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@'.'context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'CreativeWork',
            '@id' => route('project.show', $project).'#creative-work',
            'name' => $project->title,
            'description' => $projectDescription,
            'url' => route('project.show', $project),
            'image' => $projectImage,
            'creator' => [
                '@type' => 'Person',
                'name' => 'Michael Agbozo',
                'url' => url('/'),
            ],
            'keywords' => $project->tags ?: null,
            'about' => $project->services ?: null,
            'review' => $project->testimonial ? [
                '@type' => 'Review',
                'reviewBody' => $project->testimonial,
                'author' => [
                    '@type' => 'Organization',
                    'name' => $project->client_name ?: 'Client',
                ],
            ] : null,
            'dateModified' => optional($project->updated_at)->toAtomString(),
        ],
        [
            '@type' => 'BreadcrumbList',
            '@id' => route('project.show', $project).'#breadcrumb',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $project->title,
                    'item' => route('project.show', $project),
                ],
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush
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

  @if(count($quickFacts))
    <div class="grid sm:grid-cols-2 gap-4 py-10 border-b border-border">
      @foreach($quickFacts as $label => $value)
        <div class="border border-border bg-bg2/40 rounded-lg p-5">
          <div class="text-[.68rem] text-orange uppercase tracking-[.15em] font-semibold mb-2">{{ $label }}</div>
          <div class="text-white text-[.95rem] leading-relaxed">{{ $value }}</div>
        </div>
      @endforeach
    </div>
  @endif

  <div class="py-10 border-b border-border">
    <div class="text-[.7rem] text-orange uppercase tracking-[.15em] font-semibold mb-5">Project Overview</div>
    @if($project->body)
      @if(strip_tags($project->body) !== $project->body)
        <div class="project-body">{!! $project->body !!}</div>
      @else
        <div class="space-y-5">
          @foreach(array_filter(explode("\n\n", $project->body)) as $paragraph)
            <p class="text-[.95rem] text-muted leading-[1.85]">{{ $paragraph }}</p>
          @endforeach
        </div>
      @endif
    @else
      <p class="text-dim italic text-[.9rem]">No detailed write-up yet — check back soon.</p>
    @endif
  </div>

  @if(count($caseStudySections))
    <div class="py-10 border-b border-border space-y-10">
      @foreach($caseStudySections as $label => $content)
        <section>
          <div class="text-[.7rem] text-orange uppercase tracking-[.15em] font-semibold mb-4">{{ $label }}</div>
          <p class="text-[.95rem] text-muted leading-[1.85] whitespace-pre-line">{{ $content }}</p>
        </section>
      @endforeach
    </div>
  @endif

  @if($hasBeforeAfter)
    <div class="py-10 border-b border-border">
      <div class="text-[.7rem] text-orange uppercase tracking-[.15em] font-semibold mb-5">Before / After</div>
      <div class="grid sm:grid-cols-2 gap-4">
        @if($project->before_image)
          <figure class="border border-border rounded-lg overflow-hidden bg-bg2">
            <img src="{{ $project->before_image }}" alt="{{ $project->title }} before" loading="lazy" class="w-full h-auto block"/>
            <figcaption class="px-4 py-3 text-[.72rem] text-muted uppercase tracking-widest border-t border-border">Before</figcaption>
          </figure>
        @endif
        @if($project->after_image)
          <figure class="border border-border rounded-lg overflow-hidden bg-bg2">
            <img src="{{ $project->after_image }}" alt="{{ $project->title }} after" loading="lazy" class="w-full h-auto block"/>
            <figcaption class="px-4 py-3 text-[.72rem] text-muted uppercase tracking-widest border-t border-border">After</figcaption>
          </figure>
        @endif
      </div>
    </div>
  @endif

  @if($project->testimonial)
    <blockquote class="my-10 border-l-2 border-orange pl-6 text-white font-display text-[1.35rem] leading-[1.45]">
      "{{ $project->testimonial }}"
      @if($project->client_name)
        <footer class="mt-4 font-sans text-[.75rem] text-muted uppercase tracking-widest">- {{ $project->client_name }}</footer>
      @endif
    </blockquote>
  @endif

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
