@extends('layouts.app')
@section('title', $service['meta_title'])
@section('meta_description', $service['meta_description'])
@section('canonical', route('service.show', $service['slug']))
@section('og_image', asset('images/michael-hero.png'))
@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
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
                '@type' => 'Country',
                'name' => 'Ghana',
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

<section class="relative overflow-hidden border-b border-border pt-[72px]">
  <div class="hero-glow"></div>
  <div class="hero-grid-pattern"></div>
  <div class="relative max-w-[980px] mx-auto px-6 sm:px-8 pt-20 pb-20 md:pt-28 md:pb-28">
    <nav aria-label="Breadcrumb" class="flex flex-wrap gap-2 text-[.72rem] uppercase tracking-widest mb-8">
      <a href="/" class="text-muted hover:text-white transition-colors">Home</a>
      <span class="text-dim">/</span>
      <a href="/#services" class="text-muted hover:text-white transition-colors">Services</a>
      <span class="text-dim">/</span>
      <span class="text-orange">{{ $service['short_name'] }}</span>
    </nav>

    <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1.5 text-[.7rem] text-muted uppercase tracking-widest mb-8">
      <span class="w-1.5 h-1.5 rounded-full bg-orange"></span> Available in Ghana & remotely
    </div>

    <h1 class="font-display font-extrabold text-white leading-tight max-w-[850px]" style="font-size:clamp(2.5rem,6vw,5rem)">
      {{ $service['name'] }}
    </h1>

    <p class="text-muted text-[1rem] sm:text-[1.08rem] leading-[1.9] max-w-[700px] mt-7">
      {{ $service['intro'] }}
    </p>

    <div class="flex flex-wrap gap-3 mt-10">
      <a href="/#contact" class="bg-orange text-white px-7 py-3 rounded-full text-[.85rem] font-semibold hover:bg-orange2 hover:scale-[1.04] active:scale-95 transition-all duration-200">Start a Project</a>
      <a href="/#work" class="border border-border text-muted px-7 py-3 rounded-full text-[.85rem] font-medium hover:border-white hover:text-white hover:scale-[1.04] active:scale-95 transition-all duration-200">View Work</a>
    </div>
  </div>
</section>

<section class="py-20 border-b border-border">
  <div class="max-w-[1180px] mx-auto px-6 sm:px-8 md:px-12 grid grid-cols-1 lg:grid-cols-[.85fr_1.15fr] gap-12">
    <div>
      <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
        <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> Who It Helps
      </div>
      <p class="font-display font-extrabold text-white leading-tight" style="font-size:clamp(1.7rem,3vw,2.6rem)">
        Built for practical business outcomes.
      </p>
      <p class="text-muted text-[.95rem] leading-[1.85] mt-5">{{ $service['audience'] }}</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-px bg-border border border-border">
      @foreach($service['outcomes'] as $outcome)
        <div class="bg-bg p-6 hover:bg-bg3 transition-colors">
          <div class="w-8 h-0.5 bg-orange mb-5"></div>
          <p class="text-white text-[.95rem] leading-[1.7]">{{ $outcome }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="py-20 border-b border-border">
  <div class="max-w-[980px] mx-auto px-6 sm:px-8 md:px-12">
    <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
      <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> Focus Areas
    </div>
    <h2 class="font-display font-extrabold text-white leading-tight mb-8" style="font-size:clamp(1.8rem,3.5vw,3rem)">
      Clear services, easy to understand.
    </h2>
    <div class="flex flex-wrap gap-2">
      @foreach($service['keywords'] as $keyword)
        <span class="border border-border bg-bg2 text-muted rounded-full px-4 py-2 text-[.82rem]">{{ $keyword }}</span>
      @endforeach
    </div>
  </div>
</section>

<section class="py-20 border-b border-border">
  <div class="max-w-[980px] mx-auto px-6 sm:px-8 md:px-12">
    <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
      <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> FAQ
    </div>
    <div class="space-y-4">
      @foreach($service['faq'] as $item)
        <details class="group bg-bg2 border border-border rounded-xl p-5 open:border-orange">
          <summary class="cursor-pointer list-none font-display font-bold text-white text-[1rem] flex items-center justify-between gap-6">
            {{ $item['question'] }}
            <span class="text-orange group-open:rotate-45 transition-transform">+</span>
          </summary>
          <p class="text-muted text-[.92rem] leading-[1.8] mt-4">{{ $item['answer'] }}</p>
        </details>
      @endforeach
    </div>
  </div>
</section>

@if($relatedProjects->isNotEmpty())
<section class="py-20 border-b border-border">
  <div class="max-w-[1180px] mx-auto px-6 sm:px-8 md:px-12">
    <div class="flex justify-between items-end gap-6 mb-10">
      <div>
        <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
          <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> Proof
        </div>
        <h2 class="font-display font-extrabold text-white leading-tight" style="font-size:clamp(1.8rem,3.5vw,3rem)">
          Related work.
        </h2>
      </div>
      <a href="/#work" class="hidden sm:inline-flex text-orange text-[.78rem] font-semibold uppercase tracking-widest">View all →</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      @foreach($relatedProjects as $project)
        @php
          $thumb = $project->feature_image ?: ($project->images[0] ?? null);
        @endphp
        <a href="{{ route('project.show', $project) }}" class="group bg-bg2 border border-border rounded-2xl overflow-hidden hover:border-orange hover:-translate-y-1 transition-all duration-300">
          <div class="aspect-[16/10] overflow-hidden bg-bg3">
            @if($thumb)
              <img src="{{ $thumb }}" alt="{{ $project->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-[1.05] transition-transform duration-500"/>
            @else
              <div class="w-full h-full flex items-center justify-center">
                <span class="font-display font-extrabold text-[3rem] text-white/10">{{ $project->num }}</span>
              </div>
            @endif
          </div>
          <div class="p-5">
            <h3 class="font-display font-bold text-white text-[1.05rem] group-hover:text-orange transition-colors">{{ $project->title }}</h3>
            @if($project->meta)
              <p class="text-muted text-[.82rem] leading-[1.7] mt-3">{{ \Illuminate\Support\Str::limit($project->meta, 110) }}</p>
            @endif
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="py-20">
  <div class="max-w-[980px] mx-auto px-6 sm:px-8 md:px-12 text-center">
    <p class="font-display font-extrabold text-white leading-tight" style="font-size:clamp(1.8rem,3.5vw,3rem)">
      Need {{ strtolower($service['short_name']) }}?
    </p>
    <p class="text-muted text-[.95rem] leading-[1.85] max-w-[620px] mx-auto mt-5">
      Send a short message with what you want to build, improve, or launch. I will reply with the next practical step.
    </p>
    <a href="/#contact" class="inline-flex mt-8 bg-orange text-white px-8 py-3.5 rounded-full text-[.85rem] font-semibold hover:bg-orange2 hover:scale-[1.04] active:scale-95 transition-all duration-200">Contact Michael</a>
  </div>
</section>

@endsection
