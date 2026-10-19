@extends('layouts.emerald')
@php
  $projectDescription = \Illuminate\Support\Str::limit(
      trim(strip_tags($project->meta ?: $project->body ?: 'A selected web development, design, or systems project by Michael Agbozo.')),
      155,
      ''
  );
  $projectImage = $project->feature_image ?: ($project->images[0] ?? asset('images/michael-og.jpg'));
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

<section class="em-page-hero">
  @include('partials.em-backdrop', ['floor' => false])
  <div class="em-wrap em-page-hero-inner" style="padding-bottom:64px">
    <ol class="em-crumbs" aria-label="Breadcrumb">
      <li><a href="/">Home</a></li>
      <li aria-hidden="true">/</li>
      <li><a href="/#work">Work</a></li>
      <li aria-hidden="true">/</li>
      <li aria-current="page">{{ $project->title }}</li>
    </ol>
    <p class="em-eyebrow">{{ $project->num ?: 'Project' }}</p>
    <h1 class="em-page-title">{{ $project->title }}</h1>
    @if($project->meta)
      <p class="em-lede" style="max-width:720px">{{ $project->meta }}</p>
    @endif
    @if($project->tags)
      <ul class="em-chips" style="margin-top:24px">
        @foreach($project->tags as $tag)<li>{{ $tag }}</li>@endforeach
      </ul>
    @endif
    <div class="em-actions">
      @if($project->url)
        <a href="{{ $project->url }}" target="_blank" rel="noopener" class="em-btn em-btn-mint">View live project ↗</a>
      @endif
      <a href="/#work" class="em-btn em-btn-ghost">← Back to portfolio</a>
    </div>
  </div>
</section>

<div class="em-wrap" style="padding-bottom:96px">
  @if($project->feature_image)
    <div class="em-monitor-wrap" style="margin-bottom:48px">
      <figure class="em-figure em-monitor em-breathe" style="padding:0">
        <img src="{{ $project->feature_image }}" alt="{{ $project->title }}">
      </figure>
    </div>
  @endif

  <div class="em-article" style="margin:0 auto">
    @if(count($quickFacts))
      <div class="em-block" style="border-top:0">
        <div class="em-grid-2" style="grid-template-columns:repeat(auto-fill,minmax(min(100%,240px),1fr))">
          @foreach($quickFacts as $label => $value)
            <div class="em-card em-tilt {{ $loop->first ? 'is-mint' : '' }}">
              <span class="em-card-kicker">{{ $label }}</span>
              <span style="font-size:17px;font-weight:500">{{ $value }}</span>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <div class="em-block">
      <p class="em-eyebrow">Project overview</p>
      @if($project->body)
        @if(strip_tags($project->body) !== $project->body)
          <div class="em-prose">{!! $project->body !!}</div>
        @else
          <div class="em-prose">
            @foreach(array_filter(explode("\n\n", $project->body)) as $paragraph)
              <p>{{ $paragraph }}</p>
            @endforeach
          </div>
        @endif
      @else
        <p class="em-muted-note">No detailed write-up yet — check back soon.</p>
      @endif
    </div>

    @foreach($caseStudySections as $label => $content)
      <div class="em-block">
        <p class="em-eyebrow">{{ $label }}</p>
        <p class="em-prose" style="white-space:pre-line;margin:0">{{ $content }}</p>
      </div>
    @endforeach

    @if($hasBeforeAfter)
      <div class="em-block">
        <p class="em-eyebrow">Before / After</p>
        <div class="em-grid-2" style="grid-template-columns:repeat(auto-fill,minmax(min(100%,300px),1fr))">
          @if($project->before_image)
            <figure class="em-figure">
              <img src="{{ $project->before_image }}" alt="{{ $project->title }} before" loading="lazy">
              <figcaption>Before</figcaption>
            </figure>
          @endif
          @if($project->after_image)
            <figure class="em-figure">
              <img src="{{ $project->after_image }}" alt="{{ $project->title }} after" loading="lazy">
              <figcaption>After</figcaption>
            </figure>
          @endif
        </div>
      </div>
    @endif

    @if($project->testimonial)
      <div class="em-block">
        <blockquote class="em-quote">
          “{{ $project->testimonial }}”
          @if($project->client_name)
            <footer>— {{ $project->client_name }}</footer>
          @endif
        </blockquote>
      </div>
    @endif
  </div>

  @if($project->images && count($project->images))
    <div class="em-block">
      <p class="em-eyebrow">Gallery</p>
      <div class="em-gallery">
        @foreach($project->images as $img)
          <div class="em-gallery-cell">
            <button type="button" class="em-gallery-item" data-src="{{ $img }}" data-alt="{{ $project->title }} — work sample" aria-label="Open image {{ $loop->iteration }}">
              <img src="{{ $img }}" alt="{{ $project->title }} — work sample" loading="lazy">
            </button>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  <div class="em-actions" style="justify-content:center;margin-top:48px">
    @if($project->url)
      <a href="{{ $project->url }}" target="_blank" rel="noopener" class="em-btn em-btn-mint">View live project ↗</a>
    @endif
    <a href="/#work" class="em-btn em-btn-ghost">← Back to portfolio</a>
  </div>
</div>

<div class="em-lightbox" id="em-lightbox" role="dialog" aria-modal="true" aria-label="Image preview">
  <button type="button" class="em-lightbox-close" id="em-lightbox-close" aria-label="Close">✕</button>
  <figure>
    <img id="em-lightbox-img" alt="">
    <figcaption id="em-lightbox-caption"></figcaption>
  </figure>
</div>

@endsection

@push('scripts')
<script>
  (function () {
    const box = document.getElementById('em-lightbox');
    const img = document.getElementById('em-lightbox-img');
    const cap = document.getElementById('em-lightbox-caption');
    const closeBtn = document.getElementById('em-lightbox-close');
    let opener = null;
    const close = () => { box.classList.remove('is-open'); document.body.style.overflow = ''; if (opener) opener.focus(); };
    document.querySelectorAll('.em-gallery-item').forEach(btn => btn.addEventListener('click', () => {
      opener = btn;
      img.src = btn.dataset.src;
      img.alt = btn.dataset.alt || '';
      cap.textContent = btn.dataset.alt || '';
      box.classList.add('is-open');
      document.body.style.overflow = 'hidden';
      closeBtn.focus();
    }));
    closeBtn.addEventListener('click', close);
    box.addEventListener('click', (e) => { if (e.target === box) close(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && box.classList.contains('is-open')) close(); });
  })();
</script>
@endpush
