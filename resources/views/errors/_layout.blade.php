@extends('layouts.app')

@section('title', $code.' — '.$title.' | Michael Agbozo')
@section('meta_description', $message)
@section('meta_robots', 'noindex, follow')
@section('canonical', url()->current())

@section('content')
@php
  $suggestions = $suggestions ?? [
      'Return to the homepage',
      'Explore selected work',
      'Send a message if something feels wrong',
  ];
@endphp

<main class="relative min-h-screen overflow-hidden border-b border-border pt-[72px]">
  <div class="hero-glow"></div>
  <div class="hero-grid-pattern"></div>

  <section class="relative max-w-[1180px] mx-auto px-6 sm:px-8 md:px-12 py-20 md:py-28">
    <div class="grid lg:grid-cols-[1fr_380px] gap-10 lg:gap-16 items-center">
      <div>
        <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1.5 text-[.7rem] text-muted uppercase tracking-widest mb-8">
          <span class="w-1.5 h-1.5 rounded-full bg-orange"></span>
          {{ $eyebrow ?? 'Something needs attention' }}
        </div>

        <p class="font-display font-extrabold text-transparent [-webkit-text-stroke:1px_#e8531a] leading-none mb-6" style="font-size:clamp(5.5rem,18vw,13rem)">
          {{ $code }}
        </p>

        <h1 class="font-display font-extrabold text-white leading-tight mb-5 max-w-[760px]" style="font-size:clamp(2.1rem,5vw,4.8rem)">
          {{ $title }}
        </h1>

        <p class="text-muted text-[1rem] sm:text-[1.08rem] leading-[1.85] max-w-[650px] mb-10">
          {{ $message }}
        </p>

        <div class="flex flex-wrap items-center gap-3 mb-10">
          <a href="{{ url('/') }}" class="bg-orange text-white px-7 py-3 rounded-full text-[.85rem] font-semibold hover:bg-orange2 hover:scale-[1.04] active:scale-95 transition-all duration-200">
            Back Home
          </a>
          <a href="{{ url('/#work') }}" class="border border-border text-muted px-7 py-3 rounded-full text-[.85rem] font-medium hover:border-white hover:text-white hover:scale-[1.04] active:scale-95 transition-all duration-200">
            View Work
          </a>
          <a href="{{ url('/#contact') }}" class="text-muted text-[.85rem] px-4 py-3 hover:text-white transition-colors">
            Contact Michael
          </a>
        </div>

        <div class="grid sm:grid-cols-3 gap-px bg-border border border-border rounded-2xl overflow-hidden max-w-[760px]">
          @foreach($suggestions as $item)
            <div class="bg-bg/90 px-5 py-4">
              <div class="w-7 h-0.5 bg-orange mb-3"></div>
              <p class="text-[.78rem] text-muted leading-relaxed">{{ $item }}</p>
            </div>
          @endforeach
        </div>
      </div>

      <aside class="relative hidden lg:block">
        <div class="absolute -inset-7 rounded-full border border-orange/20 hero-ring-spin pointer-events-none"></div>
        <div class="absolute -inset-14 rounded-full border border-white/[.06] hero-ring-spin-rev pointer-events-none"></div>
        <div class="relative bg-bg2 border border-border rounded-2xl overflow-hidden shadow-[0_25px_80px_rgba(0,0,0,.45)]">
          <div class="aspect-square bg-bg3">
            <img src="{{ asset('images/michael-hero.png') }}" alt="Michael Agbozo" class="w-full h-full object-cover object-top opacity-90"/>
          </div>
          <div class="p-6">
            <div class="font-display font-extrabold text-white text-[1.25rem] mb-2">Michael Agbozo<span class="text-orange">.</span></div>
            <p class="text-muted text-[.85rem] leading-relaxed">
              IT systems, web development, and brand design. If this page is blocking you, the right path is only one click away.
            </p>
          </div>
        </div>
      </aside>
    </div>
  </section>
</main>
@endsection
