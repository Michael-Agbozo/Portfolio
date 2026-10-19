@extends('layouts.emerald')

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

<section class="em-page-hero" style="min-height:100vh">
  @include('partials.em-backdrop')
  <div class="em-wrap em-page-hero-inner">
    <p class="em-eyebrow em-status"><span class="em-dot em-glow"></span>{{ $eyebrow ?? 'Something needs attention' }}</p>
    <p class="em-error-code" aria-hidden="true">{{ $code }}</p>
    <h1 class="em-page-title" style="margin-top:16px">{{ $title }}</h1>
    <p class="em-lede" style="max-width:660px">{{ $message }}</p>
    <div class="em-actions">
      <a href="{{ url('/') }}" class="em-btn em-btn-mint">Back home</a>
      <a href="{{ url('/#work') }}" class="em-btn em-btn-ghost">View work</a>
      <a href="{{ url('/#contact') }}" class="em-btn em-btn-ghost">Contact Michael</a>
    </div>
    <div class="em-grid-3" style="margin-top:56px;max-width:900px">
      @foreach($suggestions as $item)
        <div class="em-card em-tilt {{ $loop->first ? 'is-mint' : '' }}">
          <span class="em-card-kicker">0{{ $loop->iteration }}</span>
          <p class="em-card-text" style="margin-top:auto">{{ $item }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
