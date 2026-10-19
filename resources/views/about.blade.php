@extends('layouts.emerald')
@use('App\Support\Thumbnail')
@section('title', __('About Michael Agbozo | Remote Web Developer, Designer and IT Systems Support'))
@section('meta_description', __('About Michael Agbozo: Ghana-based IT Systems and Web Developer offering remote Laravel development, WordPress websites, brand identity design, print cutline artwork, and IT systems support.'))
@section('canonical', route('about'))
@section('og_image', asset('images/michael-og.jpg'))
@php
  $capabilities = [
      [
          'name' => 'Laravel / Web Apps',
          'items' => ['Custom dashboards', 'Admin portals', 'Forms and workflows', 'Backend feature upgrades', 'Production support'],
      ],
      [
          'name' => 'WordPress / Websites',
          'items' => ['Business websites', 'Service pages', 'Portfolio sites', 'SEO-ready structure', 'Launch support'],
      ],
      [
          'name' => 'Brand Identity',
          'items' => ['Logo systems', 'Color and type direction', 'Social media graphics', 'Print materials', 'Reusable brand assets'],
      ],
      [
          'name' => 'Print Cutlines',
          'items' => ['Sticker cutlines', 'Label setup', 'Packaging artwork', 'Print-ready files', 'Production adjustments'],
      ],
      [
          'name' => 'IT Systems',
          'items' => ['Email setup', 'User access', 'Help desk support', 'Staff onboarding', 'Internal tool support'],
      ],
  ];

  $timeline = [
      [
          'period' => 'Current',
          'place' => 'Four Corners Community Services',
          'role' => 'IT systems, web platforms, and staff support',
          'detail' => 'Supporting daily technology operations, staff accounts, email, help desk needs, internal systems, and web platform work for a large operating team.',
      ],
      [
          'period' => 'Current',
          'place' => 'La Necar Logistics',
          'role' => 'Brand, web, and systems development',
          'detail' => 'Built the brand presence from the ground up, including visual identity, website direction, graphics, and operational web support.',
      ],
      [
          'period' => 'Independent',
          'place' => 'Freelance / Portfolio Work',
          'role' => 'Laravel, WordPress, design, and practical delivery',
          'detail' => 'Creating websites, dashboards, project pages, visual identities, and client-facing systems for Ghana-based and remote projects worldwide.',
      ],
  ];
@endphp
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
            'knowsAbout' => [
                'Laravel development',
                'WordPress website design',
                'Brand identity design',
                'Print cutline artwork',
                'IT systems support',
                'Remote web development',
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
            '@type' => ['WebPage', 'ProfilePage'],
            '@id' => route('about').'#webpage',
            'url' => route('about'),
            'name' => 'About Michael Agbozo',
            'description' => 'Ghana-based IT Systems and Web Developer available for remote Laravel, WordPress, brand identity, and IT systems projects.',
            'isPartOf' => ['@id' => url('/').'#website'],
            'about' => ['@id' => url('/').'#person'],
            'mainEntity' => ['@id' => url('/').'#person'],
        ],
        [
            '@type' => 'BreadcrumbList',
            '@id' => route('about').'#breadcrumb',
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
                    'name' => 'About',
                    'item' => route('about'),
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
      <li><a href="/">{{ __('Home') }}</a></li>
      <li aria-hidden="true">/</li>
      <li aria-current="page">{{ __('About') }}</li>
    </ol>

    <div class="em-split" style="align-items:flex-end">
      <div>
        <p class="em-eyebrow em-status"><span class="em-dot em-glow"></span>{{ __('Ghana-based · remote worldwide') }}</p>
        <h1 class="em-page-title">
          <span class="em-word em-fade" style="animation-delay:.1s">Michael</span>
          <span class="em-word em-mint" style="animation-delay:.25s">Agbozo.</span>
        </h1>
        <p class="em-page-sub">{{ __('IT Systems & Web Developer') }}</p>
        <p class="em-lede" style="max-width:640px">{{ __('I build practical websites, Laravel applications, brand systems, and IT workflows for teams that need clean execution. I am based in Ghana and available for remote projects worldwide.') }}</p>
        <div class="em-actions">
          <a href="/#contact" class="em-btn em-btn-mint">{{ __('Start a project') }}</a>
          <a href="/cv/michael-agbozo-cv.pdf" download class="em-btn em-btn-ghost">{{ __('Download CV ↓') }}</a>
        </div>
      </div>

      <div style="flex:0 1 420px;display:flex;flex-direction:column;gap:20px;align-items:center">
        <div class="em-portrait" style="position:relative;left:auto;bottom:auto;transform:none;width:220px;height:220px">
          <div class="em-orbit-ring em-orbit"><span></span></div>
          <img src="{{ Thumbnail::url('/images/michael-portrait.jpg', 400) }}" alt="{{ __('Portrait of Michael Agbozo') }}" width="220" height="220" fetchpriority="high" decoding="async" style="width:220px;height:220px">
        </div>
        <dl class="em-stats" style="width:100%;margin-top:28px">
          <div class="em-stat em-tilt"><dt>{{ __('Years design') }}</dt><dd>9<span class="em-mint">+</span></dd></div>
          <div class="em-stat em-tilt"><dt>{{ __('Years dev') }}</dt><dd>4<span class="em-mint">+</span></dd></div>
          <div class="em-stat em-tilt"><dt>{{ __('Staff supported') }}</dt><dd>370<span class="em-mint">+</span></dd></div>
        </dl>
      </div>
    </div>
  </div>
</section>

<section class="em-section">
  <div class="em-wrap em-section-pad em-split em-split-wide">
    <div>
      <p class="em-eyebrow">{{ __('Experience') }}</p>
      <h2 class="em-h2"><span class="em-fade">{{ __('Systems work with a') }}</span> <span class="em-mint">{{ __('design eye.') }}</span></h2>
      <p class="em-lede">{{ __('My work sits between design, development, and operations. That means I can think through how a site looks, how a system behaves, and how people will actually use it every day.') }}</p>
    </div>
    <div class="em-stack">
      @foreach($timeline as $item)
      <div class="em-reveal">
        <div class="em-card em-tilt em-timeline-item">
          <span class="em-card-kicker">{{ __($item['period']) }}</span>
          <div>
            <h3 class="em-card-title">{{ __($item['place']) }}</h3>
            <p style="margin:6px 0 0">{{ __($item['role']) }}</p>
            <p class="em-card-text" style="margin-top:10px">{{ __($item['detail']) }}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section class="em-section">
  <div class="em-wrap em-section-pad">
    <div class="em-section-head">
      <div>
        <p class="em-eyebrow">{{ __('Capabilities') }}</p>
        <h2 class="em-h2"><span class="em-fade">{{ __('Five ways I help teams') }}</span> <span class="em-mint">{{ __('ship.') }}</span></h2>
      </div>
      <p class="em-copy" style="margin:0;max-width:420px">{{ __('Clear services for clients who need web development, website design, brand identity, print cutlines, or ongoing IT support.') }}</p>
    </div>
    <div class="em-grid-3">
      @foreach($capabilities as $capability)
      <div class="em-reveal">
        <div class="em-card em-tilt {{ $loop->odd ? 'is-mint' : '' }}">
          <span class="em-card-kicker">0{{ $loop->iteration }}</span>
          <h3 class="em-card-title">{{ __($capability['name']) }}</h3>
          <ul class="em-plus-list">
            @foreach($capability['items'] as $item)<li>{{ __($item) }}</li>@endforeach
          </ul>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

@if($proofProjects->isNotEmpty())
<section class="em-section" style="overflow:hidden">
  <div aria-hidden="true" class="em-work-glow em-glow"></div>
  <div class="em-wrap em-section-pad" style="position:relative">
    <div class="em-section-head">
      <div>
        <p class="em-eyebrow">{{ __('Case study proof') }}</p>
        <h2 class="em-h2">{{ __('Selected work with') }} <span class="em-mint">{{ __('context.') }}</span></h2>
      </div>
      <a href="/#work" class="em-btn em-btn-ghost">{{ __('View all work →') }}</a>
    </div>
    <div class="em-grid-2">
      @foreach($proofProjects as $project)
        @php
          $thumb = $project->feature_image ?: ($project->images[0] ?? null);
          $summary = \Illuminate\Support\Str::limit($project->meta ?: strip_tags($project->body ?: 'A selected project showing Michael Agbozo work across design, web development, and systems delivery.'), 135);
        @endphp
        <div class="em-reveal">
          <a href="{{ route('project.show', $project) }}" class="em-project em-tilt">
            <div class="em-project-thumb">
              @if($thumb)
                <img src="{{ Thumbnail::url($thumb, 640) }}" srcset="{{ Thumbnail::srcset($thumb, [400, 640, 960]) }}" sizes="(max-width: 640px) 92vw, 600px" alt="{{ $project->title }}" width="640" height="400" loading="lazy" decoding="async">
              @else
                <b>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</b>
              @endif
            </div>
            <div class="em-project-body">
              <span class="em-card-kicker">{{ $project->category === 'design' ? __('Design / Brand') : __('Web / Development') }}</span>
              <span class="em-project-title"><strong>{{ $project->title }}</strong></span>
              <p class="em-project-meta">{{ $summary }}</p>
              @if($project->tags)<span class="em-project-tags">{{ implode(' · ', array_slice($project->tags, 0, 3)) }}</span>@endif
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
    <p class="em-eyebrow">{{ __('Remote work available') }}</p>
    <h2 class="em-h2"><span class="em-fade">{{ __('Need a website, system, or brand that feels') }}</span> <span class="em-mint">{{ __('solid?') }}</span></h2>
    <p>{{ __('Send a short message with what you want to build or improve. I will help you turn it into a clear next step.') }}</p>
    <div class="em-actions">
      <a href="/#contact" class="em-btn em-btn-mint">{{ __('Contact Michael') }}</a>
    </div>
  </div>
</section>

@endsection
