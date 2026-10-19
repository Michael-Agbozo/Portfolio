@extends('layouts.emerald')
@section('title', $service['meta_title'])
@section('meta_description', $service['meta_description'])
@section('canonical', route('service.show', $service['slug']))
@section('og_image', asset('images/michael-og.jpg'))
@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@'.'context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Person',
            '@id' => url('/').'#person',
            'name' => 'Michael Agbozo',
            'url' => url('/'),
            'image' => asset('images/michael-portrait.jpg'),
            'email' => 'michaelsogagbozo@gmail.com',
            'jobTitle' => 'IT Systems & Web Developer',
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'GH',
            ],
            'sameAs' => [
                'https://web.facebook.com/mykell.writes.official',
                'https://twitter.com/mykell_Writes',
                'https://www.instagram.com/mykell_writes/',
            ],
        ],
        [
            '@type' => 'WebSite',
            '@id' => url('/').'#website',
            'name' => 'Michael Agbozo Portfolio',
            'url' => url('/'),
            'publisher' => ['@id' => url('/').'#person'],
        ],
        [
            '@type' => 'WebPage',
            '@id' => route('service.show', $service['slug']).'#webpage',
            'url' => route('service.show', $service['slug']),
            'name' => $service['meta_title'],
            'description' => $service['meta_description'],
            'isPartOf' => ['@id' => url('/').'#website'],
            'about' => ['@id' => route('service.show', $service['slug']).'#service'],
        ],
        [
            '@type' => 'Service',
            '@id' => route('service.show', $service['slug']).'#service',
            'name' => $service['name'],
            'description' => $service['summary'],
            'url' => route('service.show', $service['slug']),
            'provider' => ['@id' => url('/').'#person'],
            'areaServed' => [
                [
                    '@type' => 'Country',
                    'name' => 'Ghana',
                ],
                [
                    '@type' => 'AdministrativeArea',
                    'name' => 'Remote clients worldwide',
                ],
            ],
            'serviceType' => $service['short_name'],
            'keywords' => $service['keywords'],
        ],
        [
            '@type' => 'FAQPage',
            '@id' => route('service.show', $service['slug']).'#faq',
            'mainEntity' => collect($service['faq'])->map(fn ($item) => [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'],
                ],
            ])->values()->all(),
        ],
        [
            '@type' => 'BreadcrumbList',
            '@id' => route('service.show', $service['slug']).'#breadcrumb',
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
                    'name' => 'Services',
                    'item' => url('/#services'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $service['name'],
                ],
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush
@section('content')

<section class="em-page-hero">
  @include('partials.em-backdrop')
  <div class="em-wrap em-page-hero-inner">
    <ol class="em-crumbs" aria-label="Breadcrumb">
      <li><a href="/">Home</a></li>
      <li aria-hidden="true">/</li>
      <li><a href="/#services">Services</a></li>
      <li aria-hidden="true">/</li>
      <li aria-current="page">{{ $service['short_name'] }}</li>
    </ol>
    <p class="em-eyebrow em-status"><span class="em-dot em-glow"></span>Based in Ghana · available remotely</p>
    <h1 class="em-page-title">
      @foreach(explode(' ', $service['name']) as $word)
        <span class="em-word {{ $loop->first ? 'em-fade' : ($loop->last ? 'em-mint' : '') }}" style="animation-delay:{{ number_format(0.1 + $loop->index * 0.08, 2) }}s">{{ $word }}</span>
      @endforeach
    </h1>
    <p class="em-lede" style="max-width:700px">{{ $service['intro'] }}</p>
    <div class="em-actions">
      <a href="/#contact" class="em-btn em-btn-mint">Start a project</a>
      <a href="/#work" class="em-btn em-btn-ghost">View work</a>
    </div>
  </div>
</section>

<section class="em-section">
  <div class="em-wrap em-section-pad em-split em-split-wide">
    <div>
      <p class="em-eyebrow">Who it helps</p>
      <h2 class="em-h2"><span class="em-fade">Built for practical</span> <span class="em-mint">business outcomes.</span></h2>
      <p class="em-lede">{{ $service['audience'] }}</p>
    </div>
    <div class="em-grid-2" style="grid-template-columns:repeat(auto-fill,minmax(min(100%,260px),1fr))">
      @foreach($service['outcomes'] as $outcome)
      <div class="em-reveal">
        <div class="em-card em-tilt {{ $loop->odd ? 'is-mint' : '' }}" style="min-height:180px">
          <span class="em-card-kicker">0{{ $loop->iteration }}</span>
          <p style="margin:auto 0 0;font-size:17px;font-weight:500">{{ $outcome }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section class="em-section">
  <div class="em-wrap em-section-pad">
    <p class="em-eyebrow">Focus areas</p>
    <h2 class="em-h2" style="margin-bottom:32px">Clear services, <span class="em-mint">easy to understand.</span></h2>
    <ul class="em-chips">
      @foreach($service['keywords'] as $keyword)<li>{{ $keyword }}</li>@endforeach
    </ul>
  </div>
</section>

<section class="em-section">
  <div class="em-wrap em-section-pad" style="max-width:980px">
    <p class="em-eyebrow">FAQ</p>
    <h2 class="em-h2" style="margin-bottom:32px">Questions, <span class="em-mint">answered.</span></h2>
    <div class="em-faq">
      @foreach($service['faq'] as $item)
      <details>
        <summary>{{ $item['question'] }}</summary>
        <p>{{ $item['answer'] }}</p>
      </details>
      @endforeach
    </div>
  </div>
</section>

@if($relatedProjects->isNotEmpty())
<section class="em-section" style="overflow:hidden">
  <div aria-hidden="true" class="em-work-glow em-glow"></div>
  <div class="em-wrap em-section-pad" style="position:relative">
    <div class="em-section-head">
      <div>
        <p class="em-eyebrow">Proof</p>
        <h2 class="em-h2">Related <span class="em-mint">work.</span></h2>
      </div>
      <a href="/#work" class="em-btn em-btn-ghost">View all →</a>
    </div>
    <div class="em-tile-grid">
      @foreach($relatedProjects as $project)
        @php $thumb = $project->feature_image ?: ($project->images[0] ?? null); @endphp
        <div class="em-reveal">
          <a href="{{ route('project.show', $project) }}" class="em-project em-tilt">
            <div class="em-project-thumb">
              @if($thumb)
                <img src="{{ $thumb }}" alt="{{ $project->title }}" loading="lazy" decoding="async">
              @else
                <b>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</b>
              @endif
            </div>
            <div class="em-project-body">
              <span class="em-project-title"><strong>{{ $project->title }}</strong></span>
              @if($project->meta)<p class="em-project-meta">{{ \Illuminate\Support\Str::limit($project->meta, 110) }}</p>@endif
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="em-section em-contact">
  <div aria-hidden="true" class="em-contact-curtain em-curtain"></div>
  <div aria-hidden="true" class="em-contact-glow"></div>
  <div class="em-wrap em-cta-band" style="position:relative">
    <h2 class="em-h2"><span class="em-fade">Need</span> <span class="em-mint">{{ strtolower($service['short_name']) }}?</span></h2>
    <p>Send a short message with what you want to build, improve, or launch. I will reply with the next practical step.</p>
    <div class="em-actions">
      <a href="/#contact" class="em-btn em-btn-mint">Contact Michael</a>
    </div>
  </div>
</section>

@endsection
