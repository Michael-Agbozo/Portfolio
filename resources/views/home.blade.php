@extends('layouts.app')
@section('title', 'Michael Agbozo — IT Professional, Web Developer & Designer')
@section('content')

{{-- ─── HERO ─────────────────────────────────────────────── --}}
<section class="relative overflow-hidden border-b border-border pt-[72px]">
  <div class="hero-glow"></div>
  <div class="hero-grid-pattern"></div>

  <div class="relative max-w-[760px] mx-auto px-6 sm:px-8 flex flex-col items-center text-center pt-20 pb-20 md:pt-28 md:pb-28">

    {{-- Tags --}}
    <div class="hero-line flex flex-wrap items-center justify-center gap-2 mb-9" style="animation-delay:.05s">
      <span class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1.5 text-[.7rem] text-muted uppercase tracking-widest">
        <span class="w-1.5 h-1.5 rounded-full bg-orange"></span> Available for projects
      </span>
      <span class="inline-flex items-center gap-1.5 border border-border rounded-full px-3 py-1.5 text-[.7rem] text-muted uppercase tracking-widest">
        Based in Ghana 🇬🇭
      </span>
      <span class="inline-flex items-center gap-1.5 border border-border rounded-full px-3 py-1.5 text-[.7rem] text-muted uppercase tracking-widest">
        Designer <span class="text-orange normal-case">&amp;</span> Developer
      </span>
    </div>

    {{-- Headline --}}
    <h1 class="font-display font-extrabold tracking-tight" style="font-size:clamp(2.6rem,7.5vw,5rem); line-height:1.08">
      <span class="hero-line block text-white" style="animation-delay:.16s">Strategic</span>
      <span class="hero-line block text-white" style="animation-delay:.28s">Brands <span class="text-orange">&amp;</span></span>
      <span class="hero-line block text-orange" style="animation-delay:.4s">Solid Systems<span class="text-white">.</span></span>
    </h1>

    <p class="hero-line font-display italic text-muted text-[1.1rem] sm:text-[1.35rem] mt-4 mb-10" style="animation-delay:.52s">
      thoughtful design, built to last
    </p>

    {{-- Portrait --}}
    <div class="hero-pop relative mb-10" style="animation-delay:.6s">
      <span class="absolute -inset-7 rounded-full border border-orange/20 hero-ring-spin pointer-events-none"></span>
      <span class="absolute -inset-14 rounded-full border border-white/[.06] hero-ring-spin-rev pointer-events-none"></span>
      <div class="hero-photo-float relative w-[150px] h-[150px] sm:w-[190px] sm:h-[190px] rounded-full overflow-hidden ring-4 ring-bg2 shadow-[0_25px_70px_rgba(0,0,0,.5)]">
        <img src="{{ asset('images/michael-hero.png') }}" alt="Michael Agbozo"
             class="w-full h-full object-cover object-top select-none"/>
      </div>
      <div class="absolute -bottom-1 -right-1 sm:-bottom-1.5 sm:-right-3 flex items-center gap-1 sm:gap-1.5 bg-bg2 border border-border rounded-full pl-1.5 pr-2.5 py-1 sm:pl-2 sm:pr-3.5 sm:py-1.5 shadow-[0_8px_24px_rgba(0,0,0,.4)]">
        <span class="relative flex h-2 w-2 shrink-0">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange opacity-60"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-orange"></span>
        </span>
        <span class="text-[.6rem] sm:text-[.68rem] text-white font-medium whitespace-nowrap">Open to work</span>
      </div>
    </div>

    <p class="hero-line text-muted text-[.95rem] leading-[1.8] max-w-[480px] mb-10" style="animation-delay:.7s">
      IT Systems &amp; Web Developer with 9+ years in design and 4+ years in development — building WordPress sites and Laravel applications end-to-end, managing IT operations, and crafting brand identities that last.
    </p>

    {{-- Buttons --}}
    <div class="hero-line flex flex-wrap gap-3 items-center justify-center mb-16" style="animation-delay:.8s">
      <a href="#work" class="bg-orange text-white px-7 py-3 rounded-full text-[.85rem] font-semibold hover:bg-orange2 hover:scale-[1.04] active:scale-95 transition-all duration-200">View Work</a>
      <a href="/cv/michael-agbozo-cv.pdf" download class="border border-border text-muted px-7 py-3 rounded-full text-[.85rem] font-medium hover:border-white hover:text-white hover:scale-[1.04] active:scale-95 transition-all duration-200">Download CV ↓</a>
      <a href="#contact" class="text-muted text-[.85rem] px-4 py-3 hover:text-white transition-colors">Get In Touch</a>
    </div>

    {{-- Stats --}}
    <div class="hero-line grid grid-cols-3 gap-px bg-border border border-border rounded-2xl overflow-hidden w-full max-w-[520px]" style="animation-delay:.9s">
      <div class="bg-bg py-6 text-center hover:bg-bg2 transition-colors">
        <div class="font-display font-extrabold text-[1.7rem] sm:text-[2rem] text-white">9<span class="text-orange">+</span></div>
        <div class="text-muted text-[.66rem] sm:text-[.72rem] uppercase tracking-widest mt-1">Years Design</div>
      </div>
      <div class="bg-bg py-6 text-center hover:bg-bg2 transition-colors">
        <div class="font-display font-extrabold text-[1.7rem] sm:text-[2rem] text-white">4<span class="text-orange">+</span></div>
        <div class="text-muted text-[.66rem] sm:text-[.72rem] uppercase tracking-widest mt-1">Years Dev</div>
      </div>
      <div class="bg-bg py-6 text-center hover:bg-bg2 transition-colors">
        <div class="font-display font-extrabold text-[1.7rem] sm:text-[2rem] text-white">370<span class="text-orange">+</span></div>
        <div class="text-muted text-[.66rem] sm:text-[.72rem] uppercase tracking-widest mt-1">Staff Supported</div>
      </div>
    </div>

  </div>
</section>

{{-- ─── TEXT TICKER ──────────────────────────────────────── --}}
<div class="overflow-hidden py-4 border-t-2 border-b-2 border-black/10" style="background:#e8531a">
  <div class="ticker-track flex w-max">
    @php
      $items = ['Web Design','App Design','Brand Identity','Dashboard UI','Wireframes','WordPress','Laravel','IT Systems','Print Design','Social Media'];
    @endphp
    @foreach([...$items, ...$items] as $item)
    <span class="flex items-center gap-10 px-10 font-display font-extrabold uppercase text-black whitespace-nowrap"
          style="font-size:1.35rem;letter-spacing:.06em;-webkit-text-stroke:.5px rgba(0,0,0,.15)">
      {{ $item }}<span class="opacity-60 text-[1.1rem]">✦</span>
    </span>
    @endforeach
  </div>
</div>

{{-- ─── ABOUT ────────────────────────────────────────────── --}}
<section class="py-24 border-b border-border" id="about">
<div class="max-w-[1280px] mx-auto px-12">
  <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
    <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> About Me
  </div>
  <h2 class="font-display font-extrabold text-white leading-tight mb-0" style="font-size:clamp(2rem,4vw,3.2rem)">
    Building things that<br/><span class="[-webkit-text-stroke:1px_var(--color-white)] text-transparent">actually</span> <span class="text-orange">work.</span>
  </h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start mt-14 reveal">
    <div class="space-y-4 text-muted text-[.95rem] leading-[1.85]">
      <p>I'm an IT Systems &amp; Web Developer with 9+ years in design and 4+ years in development — building WordPress sites, internal Laravel applications, and managing IT operations end-to-end. A strong mix of technical execution, design sensibility, and operational coordination, focused on building tools that save time and scale cleanly.</p>
      <p>I currently lead systems development, web platforms, and tech support across Four Corners Community Services and La Necar Logistics — delivering WordPress sites end-to-end without dev oversight, contributing Laravel backend features as part of a 3-person dev team, and keeping 370+ staff online as the sole IT point of contact (email provisioning, help desk, telecom setup).</p>
      <p>Beyond development, I bring a design background to every project — I launched La Necar Logistics' brand identity and web presence from zero, and continue to produce in-house graphics, training materials, and brand assets across both companies.</p>
    </div>
    @php
      $logos = [
        'Laravel'  => ['FF2D20', 'M23.642 5.43a.364.364 0 01.014.1v5.149c0 .135-.073.26-.189.326l-4.323 2.49v4.934a.378.378 0 01-.188.326L9.93 23.949a.316.316 0 01-.066.027c-.008.002-.016.008-.024.01a.348.348 0 01-.192 0c-.011-.002-.02-.008-.03-.012-.02-.008-.042-.014-.062-.025L.533 18.755a.376.376 0 01-.189-.326V2.974c0-.033.005-.066.014-.098.003-.012.01-.02.014-.032a.369.369 0 01.023-.058c.004-.013.015-.022.023-.033l.033-.045c.012-.01.025-.018.037-.027.014-.012.027-.024.041-.034H.53L5.043.05a.375.375 0 01.375 0L9.93 2.647h.002c.015.01.027.021.04.033l.038.027c.013.014.02.03.033.045.008.011.02.021.025.033.01.02.017.038.024.058.003.011.01.021.013.032.01.031.014.064.014.098v9.652l3.76-2.164V5.527c0-.033.004-.066.013-.098.003-.01.01-.02.013-.032a.487.487 0 01.024-.059c.007-.012.018-.02.025-.033.012-.015.021-.03.033-.043.012-.012.025-.02.037-.028.014-.01.026-.023.041-.032h.001l4.513-2.598a.375.375 0 01.375 0l4.513 2.598c.016.01.027.021.042.031.012.01.025.018.036.028.013.014.022.03.034.044.008.012.019.021.024.033.011.02.018.04.024.06.006.01.012.021.015.032zm-.74 5.032V6.179l-1.578.908-2.182 1.256v4.283zm-4.51 7.75v-4.287l-2.147 1.225-6.126 3.498v4.325zM1.093 3.624v14.588l8.273 4.761v-4.325l-4.322-2.445-.002-.003H5.04c-.014-.01-.025-.021-.04-.031-.011-.01-.024-.018-.035-.027l-.001-.002c-.013-.012-.021-.025-.031-.04-.01-.011-.021-.022-.028-.036h-.002c-.008-.014-.013-.031-.02-.047-.006-.016-.014-.027-.018-.043a.49.49 0 01-.008-.057c-.002-.014-.006-.027-.006-.041V5.789l-2.18-1.257zM5.23.81L1.47 2.974l3.76 2.164 3.758-2.164zm1.956 13.505l2.182-1.256V3.624l-1.58.91-2.182 1.255v9.435zm11.581-10.95l-3.76 2.163 3.76 2.163 3.759-2.164zm-.376 4.978L16.21 7.087 14.63 6.18v4.283l2.182 1.256 1.58.908zm-8.65 9.654l5.514-3.148 2.756-1.572-3.757-2.163-4.323 2.489-3.941 2.27z'],
        'PHP'      => ['777BB4', 'M7.01 10.207h-.944l-.515 2.648h.838c.556 0 .97-.105 1.242-.314.272-.21.455-.559.55-1.049.092-.47.05-.802-.124-.995-.175-.193-.523-.29-1.047-.29zM12 5.688C5.373 5.688 0 8.514 0 12s5.373 6.313 12 6.313S24 15.486 24 12c0-3.486-5.373-6.312-12-6.312zm-3.26 7.451c-.261.25-.575.438-.917.551-.336.108-.765.164-1.285.164H5.357l-.327 1.681H3.652l1.23-6.326h2.65c.797 0 1.378.209 1.744.628.366.418.476 1.002.33 1.752a2.836 2.836 0 0 1-.305.847c-.143.255-.33.49-.561.703zm4.024.715l.543-2.799c.063-.318.039-.536-.068-.651-.107-.116-.336-.174-.687-.174H11.46l-.704 3.625H9.388l1.23-6.327h1.367l-.327 1.682h1.218c.767 0 1.295.134 1.586.401s.378.7.263 1.299l-.572 2.944h-1.389zm7.597-2.265a2.782 2.782 0 0 1-.305.847c-.143.255-.33.49-.561.703a2.44 2.44 0 0 1-.917.551c-.336.108-.765.164-1.286.164h-1.18l-.327 1.682h-1.378l1.23-6.326h2.649c.797 0 1.378.209 1.744.628.366.417.477 1.001.331 1.751zM17.766 10.207h-.943l-.516 2.648h.838c.557 0 .971-.105 1.242-.314.272-.21.455-.559.551-1.049.092-.47.049-.802-.125-.995s-.524-.29-1.047-.29z'],
        'MySQL'    => ['4479A1', 'M16.405 5.501c-.115 0-.193.014-.274.033v.013h.014c.054.104.146.18.214.273.054.107.1.214.154.32l.014-.015c.094-.066.14-.172.14-.333-.04-.047-.046-.094-.08-.14-.04-.067-.126-.1-.18-.153zM5.77 18.695h-.927a50.854 50.854 0 00-.27-4.41h-.008l-1.41 4.41H2.45l-1.4-4.41h-.01a72.892 72.892 0 00-.195 4.41H0c.055-1.966.192-3.81.41-5.53h1.15l1.335 4.064h.008l1.347-4.064h1.095c.242 2.015.384 3.86.428 5.53zm12.325 4.08h-2.63v-5.53h.885v4.85h1.745z'],
        'JavaScript' => ['F7DF1E', 'M0 0h24v24H0V0zm22.034 18.276c-.175-1.095-.888-2.015-3.003-2.873-.736-.345-1.554-.585-1.797-1.14-.091-.33-.105-.51-.046-.705.15-.646.915-.84 1.515-.66.39.12.75.42.976.9 1.034-.676 1.034-.676 1.755-1.125-.27-.42-.404-.601-.586-.78-.63-.705-1.469-1.065-2.834-1.034l-.705.089c-.676.165-1.32.525-1.71 1.005-1.14 1.291-.811 3.541.569 4.471 1.365 1.02 3.361 1.244 3.616 2.205.24 1.17-.87 1.545-1.966 1.41-.811-.18-1.26-.586-1.755-1.336l-1.83 1.051c.21.48.45.689.81 1.109 1.74 1.756 6.09 1.666 6.871-1.004.029-.09.24-.705.074-1.65l.046.067zm-8.983-7.245h-2.248c0 1.938-.009 3.864-.009 5.805 0 1.232.063 2.363-.138 2.711-.33.689-1.18.601-1.566.48-.396-.196-.597-.466-.83-.855-.063-.105-.11-.196-.127-.196l-1.825 1.125c.305.63.75 1.172 1.324 1.517.855.51 2.004.675 3.207.405.783-.226 1.458-.691 1.811-1.411.51-.93.402-2.07.397-3.346.012-2.054 0-4.109 0-6.179l.004-.056z'],
        'Vue.js'   => ['4FC08D', 'M24,1.61H14.06L12,5.16,9.94,1.61H0L12,22.39ZM12,14.08,5.16,2.23H9.59L12,6.41l2.41-4.18h4.43Z'],
        'Tailwind' => ['06B6D4', 'M12.001,4.8c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 C13.666,10.618,15.027,12,18.001,12c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C16.337,6.182,14.976,4.8,12.001,4.8z M6.001,12c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 c1.177,1.194,2.538,2.576,5.512,2.576c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C10.337,13.382,8.976,12,6.001,12z'],
        'WordPress'=> ['21759B', 'M21.469 6.825c.84 1.537 1.318 3.3 1.318 5.175 0 3.979-2.156 7.456-5.363 9.325l3.295-9.527c.615-1.54.82-2.771.82-3.864 0-.405-.026-.78-.07-1.11m-7.981.105c.647-.03 1.232-.105 1.232-.105.582-.075.514-.93-.067-.899 0 0-1.755.135-2.88.135-1.064 0-2.85-.15-2.85-.15-.585-.03-.661.855-.075.885 0 0 .54.061 1.125.09l1.68 4.605-2.37 7.08L5.354 6.9c.649-.03 1.234-.1 1.234-.1.585-.075.516-.93-.065-.896 0 0-1.746.138-2.874.138-.2 0-.438-.008-.69-.015C4.911 3.15 8.235 1.215 12 1.215c2.809 0 5.365 1.072 7.286 2.833-.046-.003-.091-.009-.141-.009-1.06 0-1.812.923-1.812 1.914 0 .89.513 1.643 1.06 2.531.411.72.89 1.643.89 2.977 0 .915-.354 1.994-.821 3.479l-1.075 3.585-3.9-11.61.001.014zM12 22.784c-1.059 0-2.081-.153-3.048-.437l3.237-9.406 3.315 9.087c.024.053.05.101.078.149-1.12.393-2.325.609-3.582.609M1.211 12c0-1.564.336-3.05.935-4.39L7.29 21.709C3.694 19.96 1.212 16.271 1.211 12M12 0C5.385 0 0 5.385 0 12s5.385 12 12 12 12-5.385 12-12S18.615 0 12 0'],
        'Webflow'  => ['146EF5', 'm24 4.515-7.658 14.97H9.149l3.205-6.204h-.144C9.566 16.713 5.621 18.973 0 19.485v-6.118s3.596-.213 5.71-2.435H0V4.515h6.417v5.278l.144-.001 2.622-5.277h4.854v5.244h.144l2.72-5.244H24Z'],
        'Shopify'  => ['7AB55C', 'M15.337 23.979l7.216-1.561s-2.604-17.613-2.625-17.73c-.018-.116-.114-.192-.211-.192s-1.929-.136-1.929-.136-1.275-1.274-1.439-1.411c-.045-.037-.075-.057-.121-.074l-.914 21.104h.023zM11.71 11.305s-.81-.424-1.774-.424c-1.447 0-1.504.906-1.504 1.141 0 1.232 3.24 1.715 3.24 4.629 0 2.295-1.44 3.76-3.406 3.76-2.354 0-3.54-1.465-3.54-1.465l.646-2.086s1.245 1.066 2.28 1.066c.675 0 .975-.545.975-.932 0-1.619-2.654-1.694-2.654-4.359-.034-2.237 1.571-4.416 4.827-4.416 1.257 0 1.875.361 1.875.361l-.945 2.715-.02.01z'],
        'Wix'      => ['0C6EFC', 'm0 7.354 2.113 9.292h.801a1.54 1.54 0 0 0 1.506-1.218l1.351-6.34a.171.171 0 0 1 .167-.137c.08 0 .15.058.167.137l1.352 6.34a1.54 1.54 0 0 0 1.506 1.218h.805l2.113-9.292h-.565c-.62 0-1.159.43-1.296 1.035l-1.26 5.545-1.106-5.176a1.76 1.76 0 0 0-2.19-1.324c-.639.176-1.113.716-1.251 1.365l-1.094 5.127-1.26-5.537A1.33 1.33 0 0 0 .563 7.354H0z'],
        'Figma'    => ['F24E1E', 'M15.852 8.981h-4.588V0h4.588c2.476 0 4.49 2.014 4.49 4.49s-2.014 4.491-4.49 4.491zM12.735 7.51h3.117c1.665 0 3.019-1.355 3.019-3.019s-1.355-3.019-3.019-3.019h-3.117V7.51zm0 1.471H8.148c-2.476 0-4.49-2.014-4.49-4.49S5.672 0 8.148 0h4.588v8.981zm-4.587-7.51c-1.665 0-3.019 1.355-3.019 3.019s1.354 3.02 3.019 3.02h3.117V1.471H8.148zm4.587 15.019H8.148c-2.476 0-4.49-2.014-4.49-4.49s2.014-4.49 4.49-4.49h4.588v8.98zM8.148 8.981c-1.665 0-3.019 1.355-3.019 3.019s1.355 3.019 3.019 3.019h3.117V8.981H8.148zM8.172 24c-2.489 0-4.515-2.014-4.515-4.49s2.014-4.49 4.49-4.49h4.588v4.441c0 2.503-2.047 4.539-4.563 4.539zm-.024-7.51a3.023 3.023 0 0 0-3.019 3.019c0 1.665 1.365 3.019 3.044 3.019 1.705 0 3.093-1.376 3.093-3.068v-2.97H8.148zm7.704 0h-.098c-2.476 0-4.49-2.014-4.49-4.49s2.014-4.49 4.49-4.49h.098c2.476 0 4.49 2.014 4.49 4.49s-2.014 4.49-4.49 4.49zm-.097-7.509c-1.665 0-3.019 1.355-3.019 3.019s1.355 3.019 3.019 3.019h.098c1.665 0 3.019-1.355 3.019-3.019s-1.355-3.019-3.019-3.019h-.098z'],
        'GitHub Copilot' => ['181717', 'M23.922 16.997C23.061 18.492 18.063 22.02 12 22.02 5.937 22.02.939 18.492.078 16.997A.641.641 0 0 1 0 16.741v-2.869a.883.883 0 0 1 .053-.22c.372-.935 1.347-2.292 2.605-2.656.167-.429.414-1.055.644-1.517a10.098 10.098 0 0 1-.052-1.086c0-1.331.282-2.499 1.132-3.368.397-.406.89-.717 1.474-.952C7.255 2.937 9.248 1.98 11.978 1.98c2.731 0 4.767.957 6.166 2.093.584.235 1.077.546 1.474.952.85.869 1.132 2.037 1.132 3.368 0 .368-.014.733-.052 1.086.23.462.477 1.088.644 1.517 1.258.364 2.233 1.721 2.605 2.656a.841.841 0 0 1 .053.22v2.869a.641.641 0 0 1-.078.256Z'],
      ];
    @endphp
    <div class="flex flex-col gap-3">
      @foreach([
        ['Development',   ['Laravel','PHP','MySQL','JavaScript','Vue.js','Tailwind','Livewire']],
        ['CMS & Platforms',['WordPress','Webflow','Shopify','Wix']],
        ['IT & Systems',  ['Help Desk','Sys Admin','Access Mgmt']],
        ['AI-Assisted Dev',['Claude','GitHub Copilot','ChatGPT']],
        ['Design & Multimedia', ['Photoshop','Illustrator','Figma','Adobe XD','Premiere Pro','Affinity','Canva','Capcut']],
      ] as [$name, $tags])
      <div class="flex justify-between items-center px-5 py-3.5 bg-bg2 border border-border rounded-lg hover:border-orange transition-colors gap-4">
        <span class="text-[.85rem] font-medium text-white whitespace-nowrap">{{ $name }}</span>
        <div class="flex gap-1.5 flex-wrap justify-end">
          @foreach($tags as $tag)
          <span class="inline-flex items-center gap-1.5 text-[.68rem] text-muted bg-bg3 px-2 py-0.5 rounded">
            @if(isset($logos[$tag]))
              <svg viewBox="0 0 24 24" class="w-[11px] h-[11px] shrink-0" fill="#{{ $logos[$tag][0] }}" aria-hidden="true"><path d="{{ $logos[$tag][1] }}"/></svg>
            @endif
            {{ $tag }}
          </span>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
</section>

{{-- ─── MINI TICKER — outline style, reverse direction ───── --}}
<div class="overflow-hidden py-5 border-b border-border bg-bg">
  <div class="ticker-track-reverse flex w-max">
    @php
      $traits = ['Detail-Oriented','Curious','Reliable','Systems Thinker','Brand-Minded','Self-Taught','Collaborative','Always Shipping'];
    @endphp
    @foreach([...$traits, ...$traits] as $trait)
    <span class="flex items-center gap-8 px-8 font-display font-extrabold uppercase whitespace-nowrap
                 [-webkit-text-stroke:1px_#e8531a] text-transparent"
          style="font-size:1.6rem;letter-spacing:.04em">
      {{ $trait }}<span class="opacity-50 text-orange text-[1rem] [-webkit-text-stroke:0]">●</span>
    </span>
    @endforeach
  </div>
</div>

{{-- ─── SERVICES ─────────────────────────────────────────── --}}
<section class="py-24 border-b border-border" id="services">
<div class="max-w-[1280px] mx-auto px-12">
  <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
    <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> What I Do
  </div>
  <h2 class="font-display font-extrabold text-white leading-tight" style="font-size:clamp(2rem,4vw,3.2rem)">
    Services that <span class="text-orange">deliver</span><br/><span class="[-webkit-text-stroke:1px_var(--color-white)] text-transparent">real results.</span>
  </h2>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-border border border-border mt-14 reveal">
    @foreach([
      ['01','Web Development',          'WordPress websites and Laravel applications built end-to-end. Custom solutions — no bloated templates. Complete ownership from concept to launch and long-term support.'],
      ['02','Brand Identity & Design',  'Visual identity systems that communicate with precision — logos, color systems, typography, and digital materials. Brands that are memorable and built to last.'],
      ['03','IT Systems & Infrastructure','End-to-end IT management, systems administration, and internal tool development. Efficient, clean, and built to scale with the operation.'],
    ] as [$num, $name, $desc])
    <div class="bg-bg p-10 hover:bg-bg3 transition-colors">
      <div class="font-display text-[.7rem] text-orange uppercase tracking-[.15em] mb-5">{{ $num }}</div>
      <div class="w-8 h-0.5 bg-orange mb-5"></div>
      <div class="font-display text-[1.25rem] font-bold text-white mb-3 leading-tight">{{ $name }}</div>
      <p class="text-[.87rem] text-muted leading-[1.8]">{{ $desc }}</p>
    </div>
    @endforeach
  </div>
</div>
</section>

{{-- ─── WORK ─────────────────────────────────────────────── --}}
<section class="py-24 border-b border-border" id="work">
<div class="max-w-[1280px] mx-auto px-12">
  <div class="mb-12 reveal">
    <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
      <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> Portfolio
    </div>
    <h2 class="font-display font-extrabold text-white leading-tight" style="font-size:clamp(2rem,4vw,3.2rem)">
      Selected <span class="text-orange">work.</span>
    </h2>
  </div>

  @php
    $allProjects = $designProjects->concat($devProjects);
  @endphp

  @if($allProjects->isNotEmpty())
  <div class="flex flex-wrap gap-2 mb-8 reveal" id="work-filters">
    <button type="button" data-filter="all"
            class="work-filter-btn active text-[.7rem] sm:text-[.78rem] font-semibold uppercase tracking-widest px-3.5 sm:px-5 py-1.5 sm:py-2 rounded-full border transition-all">
      All
    </button>
    <button type="button" data-filter="design"
            class="work-filter-btn text-[.7rem] sm:text-[.78rem] font-semibold uppercase tracking-widest px-3.5 sm:px-5 py-1.5 sm:py-2 rounded-full border transition-all">
      Design / Branding
    </button>
    <button type="button" data-filter="development"
            class="work-filter-btn text-[.7rem] sm:text-[.78rem] font-semibold uppercase tracking-widest px-3.5 sm:px-5 py-1.5 sm:py-2 rounded-full border transition-all">
      Development
    </button>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 reveal" id="work-grid">
    @foreach($allProjects as $project)
    @php $thumb = $project->feature_image ?: ($project->images[0] ?? null); @endphp
    <a href="{{ route('project.show', $project) }}" data-category="{{ $project->category }}"
       class="work-card group bg-bg2 border border-border rounded-2xl overflow-hidden flex flex-col
              hover:border-orange hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,.5)]
              transition-all duration-300">

      {{-- Thumbnail --}}
      <div class="aspect-[16/10] overflow-hidden bg-bg3 relative">
        @if($thumb)
          <img src="{{ $thumb }}" alt="{{ $project->title }}"
               class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.05]"/>
        @else
          <div class="w-full h-full flex items-center justify-center"
               style="background:linear-gradient(135deg,#1a1a1a 0%,#222 100%)">
            <span class="font-display font-extrabold text-[4rem] leading-none"
                  style="color:#2a2a2a">{{ $project->num }}</span>
          </div>
        @endif
        {{-- Category badge --}}
        <div class="absolute top-3 left-3">
          <span class="text-[.62rem] font-semibold uppercase tracking-widest px-2.5 py-1 rounded-full bg-bg/80 backdrop-blur-sm text-muted border border-border">
            {{ $project->category === 'design' ? 'Design' : 'Dev' }}
          </span>
        </div>
      </div>

      {{-- Body --}}
      <div class="p-5 flex flex-col gap-3 flex-1">
        <h3 class="font-display font-bold text-white text-[1.15rem] leading-snug group-hover:text-orange transition-colors">
          {{ $project->title }}
        </h3>
        @if($project->meta)
        <p class="text-muted text-[.8rem] leading-relaxed line-clamp-2">{{ $project->meta }}</p>
        @endif
        @if($project->tags)
        <div class="flex gap-2 flex-wrap mt-auto pt-1">
          @foreach($project->tags as $tag)
          <span class="text-[.68rem] border border-border text-muted px-2.5 py-1 rounded-full">{{ $tag }}</span>
          @endforeach
        </div>
        @endif
      </div>
    </a>
    @endforeach
  </div>
  @endif
</div>
</section>

{{-- ─── MINI TICKER — inverted, bold ──────────────────────── --}}
<div class="overflow-hidden py-4 border-t-2 border-b-2 border-orange/30 bg-white">
  <div class="ticker-track flex w-max" style="animation-duration:38s">
    @php
      $cta = ['Got A Project?','Let\'s Build Something','Say Hello','Open For Work','Let\'s Collaborate'];
    @endphp
    @foreach([...$cta, ...$cta] as $phrase)
    <span class="flex items-center gap-10 px-10 font-display font-extrabold uppercase text-bg whitespace-nowrap"
          style="font-size:1.35rem;letter-spacing:.06em">
      {{ $phrase }}<span class="opacity-50 text-orange text-[1.1rem]">✦</span>
    </span>
    @endforeach
  </div>
</div>

{{-- ─── DESIGNS ──────────────────────────────────────────── --}}
<section class="py-24 border-b border-border" id="designs">
<div class="max-w-[1280px] mx-auto px-12">
  <div class="flex justify-between items-end mb-10 reveal">
    <div>
      <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
        <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> Social Media Design
      </div>
      <h2 class="font-display font-extrabold text-white leading-tight" style="font-size:clamp(2rem,4vw,3.2rem)">
        Design <span class="text-orange">spotlight.</span>
      </h2>
    </div>
  </div>

  @php $perPage = 16; $totalPages = (int) ceil($designs->count() / $perPage); @endphp

  <div class="design-grid reveal" id="designs-grid">
    @foreach($designs as $design)
    <div class="design-item overflow-hidden rounded-[10px] relative cursor-pointer bg-bg3 group"
         data-page="{{ intdiv($loop->index, $perPage) + 1 }}"
         onclick="openLightbox(@js($design->src), @js($design->alt))">
      <img src="{{ $design->src }}" alt="{{ $design->alt }}" loading="lazy" decoding="async"
           class="transition-transform duration-500 group-hover:scale-[1.08]"/>
      <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300
                  flex items-center justify-center"
           style="background:rgba(0,0,0,.4)">
        <div class="w-10 h-10 bg-white/15 border border-white/30 rounded-lg flex items-center justify-center
                    text-white text-lg backdrop-blur-sm">⤢</div>
      </div>
    </div>
    @endforeach
  </div>

  @if($totalPages > 1)
  <div class="flex justify-center items-center gap-2 mt-12 reveal" id="designs-pagination">
    <button type="button" data-page-nav="prev"
            class="design-page-btn w-10 h-10 flex items-center justify-center rounded-full border border-border text-muted hover:border-white hover:text-white transition-colors disabled:opacity-30 disabled:pointer-events-none">
      ←
    </button>
    @for($p = 1; $p <= $totalPages; $p++)
    <button type="button" data-page-num="{{ $p }}"
            class="design-page-btn w-10 h-10 flex items-center justify-center rounded-full border text-[.82rem] font-medium transition-colors
                   {{ $p === 1 ? 'bg-orange border-orange text-white' : 'border-border text-muted hover:border-white hover:text-white' }}">
      {{ $p }}
    </button>
    @endfor
    <button type="button" data-page-nav="next"
            class="design-page-btn w-10 h-10 flex items-center justify-center rounded-full border border-border text-muted hover:border-white hover:text-white transition-colors disabled:opacity-30 disabled:pointer-events-none">
      →
    </button>
  </div>
  @endif
</div>
</section>

{{-- ─── WORK CTA BANNER ──────────────────────────────────── --}}
<div class="max-w-[1280px] mx-auto px-12 py-12">
  <div class="reveal relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-7 bg-bg2 border border-border rounded-[2rem] px-8 sm:px-12 py-10">
    <div class="absolute -top-24 -right-16 w-72 h-72 bg-orange/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="relative text-center lg:text-left">
      <p class="inline-flex items-center gap-2 text-orange text-[.7rem] font-semibold uppercase tracking-[0.2em] mb-3">
        <span class="w-1.5 h-1.5 rounded-full bg-orange"></span> Open for new work
      </p>
      <p class="font-display font-extrabold text-white text-[1.5rem] sm:text-[1.9rem] leading-[1.2]">Lemme work on your next project</p>
    </div>

    <div class="relative flex flex-col sm:flex-row flex-wrap items-center justify-center gap-3">
      <a href="tel:0248581824"
         class="inline-flex items-center gap-2 sm:gap-2.5 bg-[#ffffff] text-[#0c0c0c] text-[.76rem] sm:text-[.85rem] font-semibold px-5 sm:px-6 py-3 sm:py-3.5 rounded-full hover:scale-[1.04] active:scale-95 transition-all duration-200 whitespace-nowrap">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="shrink-0">
          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.36 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>
        </svg>
        Lets Talk: 0248581824
      </a>
      <a href="mailto:michaelsogagbozo@gmail.com"
         class="inline-flex items-center gap-2 sm:gap-2.5 border border-white/30 text-white text-[.76rem] sm:text-[.85rem] font-semibold px-5 sm:px-6 py-3 sm:py-3.5 rounded-full hover:border-white hover:bg-white/5 hover:scale-[1.04] active:scale-95 transition-all duration-200 whitespace-normal sm:whitespace-nowrap text-center">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="shrink-0">
          <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 5L2 7"/>
        </svg>
        Email me via: michaelsogagbozo@gmail.com
      </a>
    </div>
  </div>
</div>

{{-- ─── CONTACT ──────────────────────────────────────────── --}}
<section class="py-24" id="contact">
<div class="max-w-[1280px] mx-auto px-12">
  <div class="inline-flex items-center gap-2 border border-border rounded-full px-3 py-1 text-[.7rem] text-muted uppercase tracking-widest mb-6">
    <span class="w-[5px] h-[5px] rounded-full bg-orange"></span> Contact
  </div>
  <h2 class="font-display font-extrabold text-white leading-tight mb-0" style="font-size:clamp(2rem,4vw,3.2rem)">
    Let's build something<br/><span class="text-orange">exceptional.</span>
  </h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-start mt-14">
    <div class="reveal">
      <p class="font-display font-extrabold text-white leading-tight mb-6" style="font-size:clamp(1.6rem,2.5vw,2.4rem)">
        Have a project?<br/>Let's make it <span class="text-orange">real.</span>
      </p>
      <p class="text-muted text-[.93rem] leading-[1.85] mb-8">Whether you need a solid website, a brand that stands out, or a system that actually works — reach out and let's talk about it.</p>
      <div class="flex flex-col gap-3">
        @foreach([
          ['✉','Email',   'michaelsogagbozo@gmail.com'],
          ['✆','Phone',   '0248581824'],
          ['◯','Location','Ghana — Available remotely'],
        ] as [$icon, $label, $value])
        <div class="flex items-center gap-4 px-5 py-4 bg-bg2 border border-border rounded-lg hover:border-orange transition-colors">
          <div class="w-9 h-9 bg-bg3 rounded-md flex items-center justify-center text-orange flex-shrink-0">{{ $icon }}</div>
          <div>
            <div class="text-[.68rem] text-muted uppercase tracking-widest mb-0.5">{{ $label }}</div>
            <div class="text-[.9rem] text-white font-medium">{{ $value }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <div class="reveal">
      <form class="flex flex-col gap-4" method="POST" action="{{ route('contact.send') }}">
        @csrf
        @if(session('success'))
        <div class="text-orange text-[.85rem] px-4 py-3 border border-orange rounded-lg">{{ session('success') }}</div>
        @endif
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-[.7rem] text-muted uppercase tracking-widest mb-1.5">Name</label>
            <input type="text" name="name" placeholder="Your name" value="{{ old('name') }}" required
                   class="w-full bg-bg2 border border-border text-white placeholder-dim text-[.88rem] px-4 py-3.5 rounded-lg outline-none focus:border-orange transition-colors"/>
          </div>
          <div>
            <label class="block text-[.7rem] text-muted uppercase tracking-widest mb-1.5">Email</label>
            <input type="email" name="email" placeholder="you@email.com" value="{{ old('email') }}" required
                   class="w-full bg-bg2 border border-border text-white placeholder-dim text-[.88rem] px-4 py-3.5 rounded-lg outline-none focus:border-orange transition-colors"/>
          </div>
        </div>
        <div>
          <label class="block text-[.7rem] text-muted uppercase tracking-widest mb-1.5">Subject</label>
          <input type="text" name="subject" placeholder="Project type or inquiry" value="{{ old('subject') }}" required
                 class="w-full bg-bg2 border border-border text-white placeholder-dim text-[.88rem] px-4 py-3.5 rounded-lg outline-none focus:border-orange transition-colors"/>
        </div>
        <div>
          <label class="block text-[.7rem] text-muted uppercase tracking-widest mb-1.5">Message</label>
          <textarea name="message" placeholder="Tell me about your project..." required
                    class="w-full bg-bg2 border border-border text-white placeholder-dim text-[.88rem] px-4 py-3.5 rounded-lg outline-none focus:border-orange transition-colors min-h-[140px] resize-y">{{ old('message') }}</textarea>
        </div>
        <button type="submit"
                class="bg-orange text-white font-display font-bold uppercase tracking-wide text-[.88rem] px-9 py-4 rounded-full hover:bg-orange2 transition-colors w-fit">
          Send Message →
        </button>
      </form>
    </div>
  </div>
</div>
</section>

{{-- ─── LIGHTBOX ─────────────────────────────────────────── --}}
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
  <button class="fixed top-6 right-7 w-10 h-10 rounded-full flex items-center justify-center text-white/70 text-[.85rem]
                 bg-white/8 border border-white/15 hover:bg-white/18 hover:text-white transition-all z-[10000]"
          onclick="event.stopPropagation();closeLightbox()" aria-label="Close">✕</button>
  <div class="lightbox-inner" onclick="event.stopPropagation()">
    <img id="lightbox-img" src="" alt=""/>
    <p id="lightbox-caption" class="text-[.8rem] text-white/45 italic text-center tracking-wide"></p>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function openLightbox(src, alt) {
    const lb  = document.getElementById('lightbox');
    const cap = document.getElementById('lightbox-caption');
    document.getElementById('lightbox-img').src = src;
    cap.textContent  = alt || '';
    cap.style.display = alt ? 'block' : 'none';
    lb.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
  function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
    document.body.style.overflow = '';
  }
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

  // Designs gallery pagination
  (function () {
    const grid = document.getElementById('designs-grid');
    const pagination = document.getElementById('designs-pagination');
    if (!grid || !pagination) return;

    const items = grid.querySelectorAll('.design-item');
    const numBtns = pagination.querySelectorAll('[data-page-num]');
    const prevBtn = pagination.querySelector('[data-page-nav="prev"]');
    const nextBtn = pagination.querySelector('[data-page-nav="next"]');
    const totalPages = numBtns.length;
    let current = 1;

    function render() {
      items.forEach(item => {
        item.style.display = (parseInt(item.dataset.page, 10) === current) ? '' : 'none';
      });
      numBtns.forEach(btn => {
        const isActive = parseInt(btn.dataset.pageNum, 10) === current;
        btn.classList.toggle('bg-orange', isActive);
        btn.classList.toggle('border-orange', isActive);
        btn.classList.toggle('text-white', isActive);
        btn.classList.toggle('border-border', !isActive);
        btn.classList.toggle('text-muted', !isActive);
      });
      prevBtn.disabled = current === 1;
      nextBtn.disabled = current === totalPages;
      grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    numBtns.forEach(btn => btn.addEventListener('click', () => {
      current = parseInt(btn.dataset.pageNum, 10);
      render();
    }));
    prevBtn.addEventListener('click', () => { if (current > 1) { current--; render(); } });
    nextBtn.addEventListener('click', () => { if (current < totalPages) { current++; render(); } });

    items.forEach(item => { item.style.display = (parseInt(item.dataset.page, 10) === 1) ? '' : 'none'; });
    prevBtn.disabled = true;
  })();

  // Work section filter
  const filterBtns = document.querySelectorAll('.work-filter-btn');
  const workCards  = document.querySelectorAll('.work-card');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.dataset.filter;
      workCards.forEach(card => {
        const show = filter === 'all' || card.dataset.category === filter;
        card.style.display = show ? '' : 'none';
      });
    });
  });
</script>
@endpush
