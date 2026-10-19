@php
  $seoTitle = trim($__env->yieldContent('title', 'Michael Agbozo — Portfolio'));
  $seoDescription = trim($__env->yieldContent(
      'meta_description',
      'Michael Agbozo is a Ghana-based IT systems professional, Laravel and WordPress developer, and brand designer building strategic websites, dashboards, and identities.'
  ));
  $seoCanonical = trim($__env->yieldContent('canonical', url()->current()));
  $seoImage = trim($__env->yieldContent('og_image', asset('images/michael-og.jpg')));
  $seoType = trim($__env->yieldContent('og_type', 'website'));
  $seoRobots = trim($__env->yieldContent('meta_robots', 'index, follow, max-image-preview:large'));
@endphp
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}"/>
<meta name="robots" content="{{ $seoRobots }}"/>
<link rel="canonical" href="{{ $seoCanonical }}"/>
<meta property="og:site_name" content="Michael Agbozo"/>
<meta property="og:type" content="{{ $seoType }}"/>
<meta property="og:title" content="{{ $seoTitle }}"/>
<meta property="og:description" content="{{ $seoDescription }}"/>
<meta property="og:url" content="{{ $seoCanonical }}"/>
<meta property="og:image" content="{{ $seoImage }}"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="{{ $seoTitle }}"/>
<meta name="twitter:description" content="{{ $seoDescription }}"/>
<meta name="twitter:image" content="{{ $seoImage }}"/>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"/>
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}"/>
<link rel="preconnect" href="https://www.googletagmanager.com"/>
@if($measurementId = config('services.google_analytics.measurement_id'))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $measurementId }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ $measurementId }}');
</script>
@endif
