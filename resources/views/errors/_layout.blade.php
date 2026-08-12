@extends('layouts.app')

@section('title', $code.' — '.$title.' | Michael Agbozo')
@section('meta_description', $message)
@section('meta_robots', 'noindex, follow')
@section('canonical', url()->current())

@section('content')
<main class="relative min-h-screen overflow-hidden border-b border-border pt-[72px]">
  <div class="hero-glow"></div>
  <div class="hero-grid-pattern"></div>

  <section class="relative max-w-[900px] mx-auto px-6 sm:px-8 md:px-12 py-24 md:py-32 text-center">
    <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1.5 text-[.7rem] text-muted uppercase tracking-widest mb-8">
      <span class="w-1.5 h-1.5 rounded-full bg-orange"></span>
      {{ $eyebrow ?? 'Something needs attention' }}
    </div>

    <p class="font-display font-extrabold text-orange leading-none mb-5" style="font-size:clamp(4.8rem,18vw,11rem)">
      {{ $code }}
    </p>

    <h1 class="font-display font-extrabold text-white leading-tight mb-5" style="font-size:clamp(2rem,5vw,4.2rem)">
      {{ $title }}
    </h1>

    <p class="text-muted text-[1rem] leading-[1.8] max-w-[620px] mx-auto mb-10">
      {{ $message }}
    </p>

    <div class="flex flex-wrap items-center justify-center gap-3">
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
  </section>
</main>
@endsection
