@extends('layouts.app')
@section('title', 'About Michael Agbozo | Remote Web Developer, Designer and IT Systems Support')
@section('meta_description', 'About Michael Agbozo: Ghana-based IT Systems and Web Developer offering remote Laravel development, WordPress websites, brand identity design, print cutline artwork, and IT systems support.')
@section('canonical', route('about'))
@section('og_image', asset('images/michael-hero.png'))
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
            'image' => asset('images/michael-hero.png'),
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

<section class="relative overflow-hidden border-b border-border pt-[72px]">
  <div class="hero-glow"></div>
  <div class="hero-grid-pattern"></div>
  <div class="relative max-w-[1180px] mx-auto px-6 sm:px-8 md:px-12 pt-20 pb-20 md:pt-28 md:pb-28">
    <nav aria-label="Breadcrumb" class="flex flex-wrap gap-2 text-[.72rem] uppercase tracking-widest mb-8">
      <a href="/" class="text-muted hover:text-white transition-colors">Home</a>
      <span class="text-dim">/</span>
      <span class="text-orange">About</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-[1.05fr_.95fr] gap-14 items-end">
      <div>
        <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1.5 text-[.7rem] text-muted uppercase tracking-widest mb-8">
          <span class="w-1.5 h-1.5 rounded-full bg-orange"></span> Ghana-based, remote worldwide
        </div>
        <h1 class="font-display font-extrabold text-white leading-tight max-w-[780px]" style="font-size:clamp(2.7rem,6vw,5.4rem)">
          Michael Agbozo<span class="text-orange">.</span>
        </h1>
        <p class="font-display font-bold text-white text-[1.15rem] sm:text-[1.45rem] mt-5">
          IT Systems &amp; Web Developer
        </p>
        <p class="text-muted text-[1rem] sm:text-[1.08rem] leading-[1.9] max-w-[690px] mt-7">
          I build practical websites, Laravel applications, brand systems, and IT workflows for teams that need clean execution. I am based in Ghana and available for remote projects worldwide.
        </p>
        <div class="flex flex-wrap gap-3 mt-10">
          <a href="/#contact" class="bg-orange text-white px-7 py-3 rounded-full text-[.85rem] font-semibold hover:bg-orange2 hover:scale-[1.04] active:scale-95 transition-all duration-200">Start a Project</a>
          <a href="/cv/michael-agbozo-cv.pdf" download class="border border-border text-muted px-7 py-3 rounded-full text-[.85rem] font-medium hover:border-white hover:text-white hover:scale-[1.04] active:scale-95 transition-all duration-200">Download CV</a>
        </div>
      </div>

      <div class="grid grid-cols-3 gap-px bg-border border border-border rounded-2xl overflow-hidden">
        @foreach([
          ['9+', 'Years Design'],
          ['4+', 'Years Dev'],
          ['370+', 'Staff Supported'],
        ] as [$number, $label])
          <div class="bg-bg p-5 sm:p-7 text-center hover:bg-bg2 transition-colors">
            <div class="font-display font-extrabold text-[1.65rem] sm:text-[2.2rem] text-white">{{ $number }}</div>
            <div class="text-muted text-[.62rem] sm:text-[.7rem] uppercase tracking-widest mt-2">{{ $label }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<section class="py-20 border-b border-border">
  <div class="max-w-[1180px] mx-auto px-6 sm:px-8 md:px-12 grid grid-cols-1 lg:grid-cols-[.8fr_1.2fr] gap-14">
    <div>
      <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
        <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> Experience
      </div>
      <h2 class="font-display font-extrabold text-white leading-tight" style="font-size:clamp(2rem,4vw,3.2rem)">
        Systems work with a <span class="text-orange">design eye.</span>
      </h2>
      <p class="text-muted text-[.95rem] leading-[1.85] mt-6">
        My work sits between design, development, and operations. That means I can think through how a site looks, how a system behaves, and how people will actually use it every day.
      </p>
    </div>

    <div class="space-y-4">
      @foreach($timeline as $item)
        <div class="grid grid-cols-1 sm:grid-cols-[150px_1fr] gap-5 bg-bg2 border border-border rounded-2xl p-6 hover:border-orange transition-colors">
          <div class="text-orange font-display font-extrabold text-[.85rem] uppercase tracking-[.16em]">{{ $item['period'] }}</div>
          <div>
            <h3 class="font-display font-bold text-white text-[1.15rem]">{{ $item['place'] }}</h3>
            <p class="text-white text-[.9rem] mt-2">{{ $item['role'] }}</p>
            <p class="text-muted text-[.88rem] leading-[1.8] mt-3">{{ $item['detail'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="py-20 border-b border-border">
  <div class="max-w-[1180px] mx-auto px-6 sm:px-8 md:px-12">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
      <div>
        <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
          <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> Capabilities
        </div>
        <h2 class="font-display font-extrabold text-white leading-tight" style="font-size:clamp(2rem,4vw,3.2rem)">
          Five ways I help teams <span class="text-orange">ship.</span>
        </h2>
      </div>
      <p class="text-muted text-[.92rem] leading-[1.8] max-w-[420px]">
        Clear services for clients who need web development, website design, brand identity, print cutlines, or ongoing IT support.
      </p>
    </div>

    <div class="service-offer-grid">
      @foreach($capabilities as $capability)
        <div class="bg-bg p-7 hover:bg-bg3 transition-colors">
          <div class="w-8 h-0.5 bg-orange mb-5"></div>
          <h3 class="font-display font-bold text-white text-[1.18rem] leading-tight">{{ $capability['name'] }}</h3>
          <ul class="mt-6 space-y-3">
            @foreach($capability['items'] as $item)
              <li class="flex gap-3 text-muted text-[.86rem] leading-[1.65]">
                <span class="text-orange mt-[.18rem]">+</span>
                <span>{{ $item }}</span>
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>
  </div>
</section>

@if($proofProjects->isNotEmpty())
<section class="py-20 border-b border-border">
  <div class="max-w-[1180px] mx-auto px-6 sm:px-8 md:px-12">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
      <div>
        <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
          <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> Case Study Proof
        </div>
        <h2 class="font-display font-extrabold text-white leading-tight" style="font-size:clamp(2rem,4vw,3.2rem)">
          Selected work with <span class="text-orange">context.</span>
        </h2>
      </div>
      <a href="/#work" class="text-orange text-[.78rem] font-semibold uppercase tracking-widest">View all work -></a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
      @foreach($proofProjects as $project)
        @php
          $thumb = $project->feature_image ?: ($project->images[0] ?? null);
          $summary = \Illuminate\Support\Str::limit($project->meta ?: strip_tags($project->body ?: 'A selected project showing Michael Agbozo work across design, web development, and systems delivery.'), 135);
        @endphp
        <a href="{{ route('project.show', $project) }}" class="group bg-bg2 border border-border rounded-2xl overflow-hidden hover:border-orange hover:-translate-y-1 transition-all duration-300">
          <div class="grid grid-cols-1 sm:grid-cols-[190px_1fr] min-h-full">
            <div class="aspect-[16/10] sm:aspect-auto bg-bg3 overflow-hidden">
              @if($thumb)
                <img src="{{ $thumb }}" alt="{{ $project->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-[1.05] transition-transform duration-500"/>
              @else
                <div class="w-full h-full min-h-[160px] flex items-center justify-center">
                  <span class="font-display font-extrabold text-[4rem] text-white/10">{{ $project->num }}</span>
                </div>
              @endif
            </div>
            <div class="p-6">
              <div class="text-orange font-display text-[.68rem] uppercase tracking-[.16em] mb-3">{{ $project->category === 'design' ? 'Design / Brand' : 'Web / Development' }}</div>
              <h3 class="font-display font-bold text-white text-[1.18rem] leading-tight group-hover:text-orange transition-colors">{{ $project->title }}</h3>
              <p class="text-muted text-[.86rem] leading-[1.75] mt-4">{{ $summary }}</p>
              @if($project->tags)
                <div class="flex gap-2 flex-wrap mt-5">
                  @foreach(array_slice($project->tags, 0, 3) as $tag)
                    <span class="text-[.66rem] border border-border text-muted px-2.5 py-1 rounded-full">{{ $tag }}</span>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="py-20">
  <div class="max-w-[980px] mx-auto px-6 sm:px-8 md:px-12 text-center">
    <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
      <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> Remote Work Available
    </div>
    <p class="font-display font-extrabold text-white leading-tight" style="font-size:clamp(2rem,4vw,3.2rem)">
      Need a website, system, or brand that feels <span class="text-orange">solid?</span>
    </p>
    <p class="text-muted text-[.95rem] leading-[1.85] max-w-[660px] mx-auto mt-6">
      Send a short message with what you want to build or improve. I will help you turn it into a clear next step.
    </p>
    <a href="/#contact" class="inline-flex mt-8 bg-orange text-white px-8 py-3.5 rounded-full text-[.85rem] font-semibold hover:bg-orange2 hover:scale-[1.04] active:scale-95 transition-all duration-200">Contact Michael</a>
  </div>
</section>

@endsection
