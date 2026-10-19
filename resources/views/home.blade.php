@extends('layouts.emerald')
@use('App\Support\Thumbnail')
@section('title', 'Michael Agbozo — IT Professional, Web Developer & Designer')
@section('meta_description', 'Michael Agbozo offers Laravel development, WordPress website design, brand identity design, print cutline artwork, and IT systems support in Ghana and remotely.')
@section('canonical', url('/'))
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
            'knowsAbout' => [
                'Laravel development',
                'WordPress development',
                'IT systems administration',
                'Brand identity design',
                'Print cutline artwork',
                'Dashboard UI design',
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
            '@type' => 'ProfessionalService',
            '@id' => url('/').'#service',
            'name' => 'Michael Agbozo',
            'url' => url('/'),
            'image' => asset('images/michael-og.jpg'),
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
            'serviceType' => collect($services)->pluck('short_name')->values()->all(),
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Web, brand, and IT services',
                'itemListElement' => collect($services)->map(fn ($service, $slug) => [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => $service['name'],
                        'url' => route('service.show', $slug),
                        'description' => $service['summary'],
                    ],
                ])->values()->all(),
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush
@section('content')
@php
  $allProjects = $designProjects->concat($devProjects);
  $latestProjects = $allProjects->sortByDesc('id')->take(3);
  $thumbFor = fn ($project) => $project->feature_image ?: ($project->images[0] ?? null);
  $whatsappUrl = 'https://wa.me/233248581824?text='.rawurlencode("Hi Michael, I found your portfolio and I'd like to reach out.\n\nName:\nEmail:\nHow can you help me:");
  $serviceSlugs = [
      'laravel-development-ghana',
      'wordpress-website-design-ghana',
      'brand-identity-design-ghana',
      'print-cutline-artwork-ghana',
      'it-systems-support-ghana',
  ];
  $ringTools = ['Laravel', 'PHP', 'MySQL', 'Vue.js', 'WordPress', 'Figma', 'Photoshop', 'Tailwind'];
  $tools = ['Laravel', 'PHP', 'MySQL', 'JavaScript', 'Vue.js', 'Tailwind', 'Livewire', 'WordPress', 'Webflow', 'Shopify', 'Figma', 'Photoshop', 'Illustrator', 'Premiere Pro', 'Claude', 'GitHub Copilot'];
  $perPage = 16;
  $totalPages = (int) ceil($designs->count() / $perPage);
@endphp

{{-- ─── HERO ─────────────────────────────────────────────── --}}
<section class="em-hero" id="top">
  <div aria-hidden="true" class="em-hero-curtain em-curtain"></div>
  <div aria-hidden="true" class="em-hero-glow em-glow"></div>
  <div aria-hidden="true" class="em-hero-fade"></div>
  <div aria-hidden="true" class="em-floor-wrap"><div class="em-floor"></div></div>

  <div class="em-wrap em-hero-grid">
    <div class="em-hero-copy">
      <p class="em-eyebrow em-status"><span class="em-dot em-glow"></span>Open to work · Ghana &amp; remote</p>
      <h1 class="em-h1">
        <span class="em-word em-fade" style="animation-delay:.1s">Strategic</span>
        <span class="em-word" style="animation-delay:.2s">brands</span>
        <span class="em-word" style="animation-delay:.3s">&amp;</span>
        <span class="em-word em-mint" style="animation-delay:.4s">solid</span>
        <span class="em-word em-mint" style="animation-delay:.5s">systems.</span>
      </h1>
      <p class="em-lede">IT Systems &amp; Web Developer with 9+ years in design and 4+ in development. I build WordPress sites and Laravel apps end to end, keep IT running, and craft brands that last.</p>
    </div>

    {{-- 3D scene: tilted dashboard window, orbiting portrait, floating chips --}}
    <div class="em-scene" aria-hidden="true">
      <div class="em-scene-inner em-float">
        <div class="em-window" id="em-window">
          <div class="em-window-bar">
            <span class="em-tl em-tl-y"></span><span class="em-tl em-tl-g"></span><span class="em-tl em-tl-r"></span>
            <span class="em-window-url">agbozo.dev/dashboard</span>
          </div>
          <div class="em-window-body">
            <div class="em-window-side">
              <span class="em-new">+ New Project</span>
              <span class="is-active">Overview</span>
              <span>Projects</span>
              <span>Designs</span>
              <span>Media</span>
              <span>Messages</span>
              <span>CV</span>
              <span>Security</span>
              <span>Logs</span>
            </div>
            <div class="em-window-main">
              <div class="em-eyebrow" style="font-size:11px;margin:0">Dashboard</div>
              <div class="em-window-title">Overview</div>
              <div class="em-window-cards">
                <div class="em-window-card"><small>Active projects</small><strong>{{ $allProjects->count() }}</strong></div>
                <div class="em-window-card"><small>Designs</small><strong>{{ $designs->count() }}</strong></div>
              </div>
              @if($latestProjects->isNotEmpty())
              <div class="em-window-list">
                <div style="color:var(--em-muted)">LATEST PROJECTS</div>
                @foreach($latestProjects as $project)
                <div><span>{{ $project->title }}</span><span class="em-mint">● Active</span></div>
                @endforeach
              </div>
              @endif
            </div>
          </div>
        </div>

        <div class="em-portrait">
          <div class="em-orbit-ring em-orbit"><span></span></div>
          <img src="{{ Thumbnail::url('/images/michael-portrait.jpg', 400) }}" alt="Michael Agbozo" width="200" height="200" fetchpriority="high" decoding="async">
        </div>

        <span class="em-chip em-chip-1 em-bob">Laravel</span>
        <span class="em-chip em-chip-mint em-chip-2 em-bob">Brand Identity</span>
        <span class="em-chip em-chip-3 em-bob">WordPress</span>
      </div>
    </div>

    {{-- Buttons on the left, stats on the right, on one line --}}
    <div class="em-hero-bar">
      <div class="em-actions">
        <a href="#work" class="em-btn em-btn-mint">View my work</a>
        <a href="/cv/michael-agbozo-cv.pdf" download class="em-btn em-btn-ghost">Download CV ↓</a>
      </div>
      <dl class="em-stats">
        <div class="em-stat em-tilt"><dt>Years design</dt><dd>9<span class="em-mint">+</span></dd></div>
        <div class="em-stat em-tilt"><dt>Years dev</dt><dd>4<span class="em-mint">+</span></dd></div>
        <div class="em-stat em-tilt"><dt>Staff supported</dt><dd>370<span class="em-mint">+</span></dd></div>
      </dl>
    </div>
  </div>
</section>

{{-- ─── SERVICES ─────────────────────────────────────────── --}}
<section class="em-wrap em-section-pad" id="services">
  <p class="em-eyebrow">What I do</p>
  <h2 class="em-h2" style="margin-bottom:48px;max-width:820px"><span class="em-fade">Services that</span> deliver <span class="em-mint">real results.</span></h2>
  <div class="em-tile-grid">
    @foreach($serviceSlugs as $slug)
    @php $service = $services[$slug]; @endphp
    <div class="em-reveal">
      <a href="{{ route('service.show', $slug) }}" class="em-service em-tilt {{ $loop->even ? 'is-dark' : 'is-mint' }}">
        <span class="em-service-num">0{{ $loop->iteration }}</span>
        <span class="em-service-name">{{ $service['short_name'] }}</span>
        <span class="em-service-text">{{ $service['summary'] }}</span>
        <span class="em-pill-cta">Learn more</span>
      </a>
    </div>
    @endforeach
    <div class="em-reveal">
      <a href="#contact" class="em-service em-tilt is-dark">
        <span class="em-service-num">06</span>
        <span class="em-service-name">Something else?</span>
        <span class="em-service-text">Have an idea that doesn’t fit a box? Tell me about it and we’ll work out the right approach together.</span>
        <span class="em-pill-cta">Get in touch</span>
      </a>
    </div>
  </div>
</section>

{{-- ─── WORK ─────────────────────────────────────────────── --}}
<section class="em-section" id="work" style="overflow:hidden">
  <div aria-hidden="true" class="em-work-glow em-glow"></div>
  <div class="em-wrap em-section-pad" style="position:relative">
    <div class="em-section-head">
      <div>
        <p class="em-eyebrow">Portfolio</p>
        <h2 class="em-h2">Selected <span class="em-mint">work.</span></h2>
      </div>
      @if($allProjects->isNotEmpty())
      <div class="em-filters" role="group" aria-label="Filter projects">
        <button type="button" class="em-filter" data-filter="all" aria-pressed="true">All</button>
        <button type="button" class="em-filter" data-filter="design" aria-pressed="false">Design</button>
        <button type="button" class="em-filter" data-filter="development" aria-pressed="false">Development</button>
      </div>
      @endif
    </div>

    @if($allProjects->isEmpty())
      <div class="em-empty">New projects are on the way — check back soon.</div>
    @else
    {{-- Tilted monitor showing project frames --}}
    <div class="em-monitor-wrap" aria-hidden="true">
      <div class="em-monitor em-breathe">
        <div class="em-monitor-tabs"><span>PORTFOLIO — AGBOZO</span>@foreach($allProjects->take(2) as $project)<span>CLIENT — {{ strtoupper($project->title) }}</span>@endforeach</div>
        <div class="em-monitor-view">
          <div class="em-slide-track em-slide">
            @foreach([1, 2] as $copy)
              @foreach($allProjects->concat($allProjects)->take(max(10, $allProjects->count())) as $project)
              @php $thumb = $thumbFor($project); @endphp
              <div class="em-frame {{ $thumb ? 'has-img' : ($loop->index % 3 === 1 ? 'is-mint' : '') }}">
                @if($thumb)<img src="{{ Thumbnail::url($thumb, 480) }}" alt="{{ $project->title }} website" width="220" height="300" loading="lazy" decoding="async">@endif
                <span>{{ $project->title }}</span>
              </div>
              @endforeach
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="em-tile-grid" id="em-work-grid">
      @foreach($allProjects as $project)
      @php $thumb = $thumbFor($project); @endphp
      <div class="em-reveal em-work-item" data-category="{{ $project->category }}">
        <a href="{{ route('project.show', $project) }}" class="em-project em-tilt">
          <div class="em-project-thumb">
            @if($thumb)
              <img src="{{ Thumbnail::url($thumb, 640) }}" srcset="{{ Thumbnail::srcset($thumb, [400, 640, 960]) }}" sizes="(max-width: 640px) 92vw, 400px" alt="{{ $project->title }}" width="640" height="400" loading="lazy" decoding="async">
            @else
              <b>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</b>
            @endif
          </div>
          <div class="em-project-body">
            <span class="em-project-title"><strong>{{ $project->title }}</strong><small>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</small></span>
            @if($project->meta)<p class="em-project-meta">{{ $project->meta }}</p>@endif
            @if($project->tags)<span class="em-project-tags">{{ implode(' · ', $project->tags) }}</span>@endif
          </div>
        </a>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

{{-- ─── DESIGNS ──────────────────────────────────────────── --}}
<section class="em-section em-designs" id="designs">
  <div class="em-wrap em-section-pad">
    <div class="em-section-head">
      <h2 class="em-h2">Design <span class="em-mint">wall.</span></h2>
      @if($designs->isNotEmpty())
      <span class="em-btn em-btn-ghost" style="pointer-events:none">{{ $designs->count() }} designs</span>
      @endif
    </div>

    @if($designs->isEmpty())
      <div class="em-empty">Designs coming soon — check back shortly.</div>
    @else
    <div class="em-design-grid" id="em-designs-grid">
      @foreach($designs as $design)
      <div class="em-design-cell em-reveal" data-page="{{ intdiv($loop->index, $perPage) + 1 }}">
        <button type="button" class="em-design em-flip"
                data-src="{{ $design->src }}" data-alt="{{ $design->alt ?: 'Design by Michael Agbozo' }}">
          <span class="em-face em-face-front">
            <img src="{{ Thumbnail::url($design->src, 400) }}" srcset="{{ Thumbnail::srcset($design->src, [400, 640]) }}" sizes="(max-width: 640px) 92vw, 300px" alt="{{ $design->alt ?: 'Design by Michael Agbozo' }}" width="400" height="400" loading="lazy" decoding="async">
            <span class="em-face-title">{{ $design->alt }}</span>
          </span>
          <span class="em-face em-face-back">
            <span class="em-face-kicker">Design</span>
            <span class="em-face-cta">View design ↗</span>
            <span style="font-size:13px;opacity:.8">{{ $design->alt }}</span>
          </span>
        </button>
      </div>
      @endforeach
    </div>

    @if($totalPages > 1)
    <nav class="em-pager" id="em-designs-pager" aria-label="Design pages">
      <button type="button" data-nav="prev" aria-label="Previous page" disabled>←</button>
      @for($p = 1; $p <= $totalPages; $p++)
      <button type="button" data-page-num="{{ $p }}" aria-current="{{ $p === 1 ? 'true' : 'false' }}">{{ $p }}</button>
      @endfor
      <button type="button" data-nav="next" aria-label="Next page">→</button>
    </nav>
    @endif
    @endif
  </div>
</section>

{{-- ─── ABOUT ────────────────────────────────────────────── --}}
<section class="em-section" id="about">
  <div class="em-wrap em-section-pad em-about">
    <div class="em-badge-stage" aria-hidden="true">
      <div class="em-tool-ring em-ring">
        @foreach($ringTools as $tool)
        <span style="--i: {{ $loop->index }}">{{ $tool }}</span>
        @endforeach
      </div>
      <div class="em-badge em-spin">
        <div class="em-badge-face em-badge-front">
          <svg aria-hidden="true" width="130" height="92" viewBox="0 0 34 24"><path d="M4 22V2h6l7 10 7-10h6v20h-6V12l-7 9-7-9v10z" fill="currentColor"/></svg>
        </div>
        <div class="em-badge-face em-badge-back">9+</div>
      </div>
    </div>
    <div class="em-about-copy">
      <h2 class="em-h2" style="margin-bottom:24px"><span class="em-fade">Building things that</span> actually <span class="em-mint">work.</span></h2>
      <p>I lead systems development, web platforms and tech support across Four Corners Community Services and La Necar Logistics. I deliver WordPress sites end to end, contribute Laravel backend features in a three-person dev team, and keep 370+ staff online as the sole IT point of contact.</p>
      <p>Design is where I started: I launched La Necar Logistics’ brand identity and website from zero, and still make graphics, training materials and brand assets for both companies.</p>
      <ul class="em-tools">
        @foreach($tools as $tool)<li>{{ $tool }}</li>@endforeach
      </ul>
    </div>
  </div>
</section>

{{-- ─── CONTACT ──────────────────────────────────────────── --}}
<section class="em-section em-contact" id="contact">
  <div aria-hidden="true" class="em-contact-curtain em-curtain"></div>
  <div aria-hidden="true" class="em-contact-glow"></div>
  <div class="em-wrap em-contact-grid" id="em-contact-area">
    <div class="em-contact-copy">
      <h2 class="em-contact-title"><span class="em-fade">Have a project?</span> Let’s make it <span class="em-mint">real.</span></h2>
      <p>A solid website, a brand that stands out, or a system that actually works. I’m available for projects in Ghana and remotely worldwide.</p>
      <ul class="em-contact-list">
        <li><a href="mailto:michaelsogagbozo@gmail.com">michaelsogagbozo@gmail.com</a></li>
        <li><a href="tel:0248581824">0248581824</a></li>
      </ul>
      <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="em-btn em-btn-outline" style="align-self:flex-start">
        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-12.3 7.4L3 21l2.1-5.6A8.4 8.4 0 1 1 21 11.5z"/></svg>
        Chat on WhatsApp
      </a>
    </div>

    <form class="em-form" id="em-form" method="POST" action="{{ route('contact.send') }}">
      @csrf
      <div class="em-form-dots" aria-hidden="true">
        <span class="em-tl em-tl-y"></span><span class="em-tl em-tl-g"></span><span class="em-tl em-tl-r"></span>
      </div>
      {{-- Honeypot: hidden from real visitors, but bots tend to fill in every
           field they find. If this has a value, we quietly ignore the submission. --}}
      <div class="hp-field" aria-hidden="true">
        <label for="website">Website</label>
        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off"/>
      </div>
      <input type="hidden" name="contact_started_at" value="{{ $contactFormStartedAt }}">
      <input type="hidden" name="contact_signature" value="{{ $contactFormSignature }}">
      <input type="hidden" name="subject" value="{{ old('subject', 'New enquiry from your portfolio') }}">

      @if(session('success'))
      <div class="em-alert em-alert-ok" role="status">{{ session('success') }}</div>
      @endif
      @if($errors->any())
      <div class="em-alert em-alert-err" role="alert">
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
      @endif

      <label class="em-field">Your name
        <input type="text" name="name" value="{{ old('name') }}" autocomplete="name" required>
      </label>
      <label class="em-field">Email
        <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
      </label>
      <label class="em-field">How can I help?
        <textarea name="message" rows="4" required>{{ old('message') }}</textarea>
      </label>
      <button type="submit" class="em-btn em-btn-mint" style="border:0">Send message</button>
    </form>
  </div>
</section>

{{-- ─── LIGHTBOX ─────────────────────────────────────────── --}}
<div class="em-lightbox" id="em-lightbox" role="dialog" aria-modal="true" aria-label="Design preview">
  <button type="button" class="em-lightbox-close" id="em-lightbox-close" aria-label="Close">✕</button>
  <figure>
    <img id="em-lightbox-img" alt="Enlarged design preview">
    <figcaption id="em-lightbox-caption"></figcaption>
  </figure>
</div>
@endsection

@push('scripts')
<script>
  const emReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Hero dashboard window tilts towards the mouse
  (function () {
    const hero = document.getElementById('top');
    const win = document.getElementById('em-window');
    if (!hero || !win || emReduced) return;
    hero.addEventListener('mousemove', (e) => {
      const r = hero.getBoundingClientRect();
      const x = (e.clientX - r.left) / r.width - 0.5;
      const y = (e.clientY - r.top) / r.height - 0.5;
      win.style.transform = `rotateX(${(10 - y * 12).toFixed(2)}deg) rotateY(${(-18 + x * 18).toFixed(2)}deg) rotateZ(2deg)`;
    });
    hero.addEventListener('mouseleave', () => { win.style.transform = ''; });
  })();

  // Contact form tilts towards the mouse
  (function () {
    const area = document.getElementById('em-contact-area');
    const form = document.getElementById('em-form');
    if (!area || !form || emReduced) return;
    area.addEventListener('mousemove', (e) => {
      const r = area.getBoundingClientRect();
      const cx = -((e.clientY - r.top) / r.height - 0.5) * 10;
      const cy = ((e.clientX - r.left) / r.width - 0.5) * 14;
      form.style.transform = `rotateX(${cx.toFixed(2)}deg) rotateY(${cy.toFixed(2)}deg)`;
    });
    area.addEventListener('mouseleave', () => { form.style.transform = ''; });
  })();

  // Work filter
  (function () {
    const buttons = document.querySelectorAll('.em-filter');
    const items = document.querySelectorAll('.em-work-item');
    buttons.forEach(btn => btn.addEventListener('click', () => {
      buttons.forEach(b => b.setAttribute('aria-pressed', String(b === btn)));
      const filter = btn.dataset.filter;
      items.forEach(item => {
        item.style.display = (filter === 'all' || item.dataset.category === filter) ? '' : 'none';
      });
    }));
  })();

  // Design wall pages
  (function () {
    const grid = document.getElementById('em-designs-grid');
    const pager = document.getElementById('em-designs-pager');
    if (!grid) return;
    const cells = grid.querySelectorAll('.em-design-cell');
    const show = (page) => cells.forEach(c => { c.style.display = Number(c.dataset.page) === page ? '' : 'none'; });
    show(1);
    if (!pager) return;
    const nums = pager.querySelectorAll('[data-page-num]');
    const prev = pager.querySelector('[data-nav="prev"]');
    const next = pager.querySelector('[data-nav="next"]');
    let current = 1;
    const go = (page) => {
      current = page;
      show(page);
      nums.forEach(b => b.setAttribute('aria-current', String(Number(b.dataset.pageNum) === page)));
      prev.disabled = page === 1;
      next.disabled = page === nums.length;
      grid.scrollIntoView({ behavior: emReduced ? 'auto' : 'smooth', block: 'start' });
    };
    nums.forEach(b => b.addEventListener('click', () => go(Number(b.dataset.pageNum))));
    prev.addEventListener('click', () => current > 1 && go(current - 1));
    next.addEventListener('click', () => current < nums.length && go(current + 1));
  })();

  // Lightbox for designs
  (function () {
    const box = document.getElementById('em-lightbox');
    const img = document.getElementById('em-lightbox-img');
    const cap = document.getElementById('em-lightbox-caption');
    const closeBtn = document.getElementById('em-lightbox-close');
    let opener = null;
    const close = () => {
      box.classList.remove('is-open');
      document.body.style.overflow = '';
      if (opener) opener.focus();
    };
    document.querySelectorAll('.em-design').forEach(btn => btn.addEventListener('click', () => {
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
