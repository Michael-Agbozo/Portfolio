<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>@yield('title', 'Michael Agbozo — Portfolio')</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet"/>
@vite(['resources/css/portfolio.css'])
@stack('head')
</head>
<body>

<!-- NAV -->
<nav id="nav">
  <a href="/" class="nav-logo">Michael<span>.</span></a>
  <ul class="nav-links">
    <li><a href="#about">About</a></li>
    <li><a href="#services">Services</a></li>
    <li><a href="#work">Work</a></li>
    <li><a href="#designs">Designs</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
  <a href="#contact" class="nav-pill">Let's Talk</a>
</nav>

@yield('content')

<!-- FOOTER -->
<footer>
  <div class="footer-logo">Michael<span>.</span></div>
  <div class="footer-socials">
    <a href="https://web.facebook.com/mykell.writes.official" target="_blank" rel="noopener">Facebook</a>
    <a href="https://twitter.com/mykell_Writes" target="_blank" rel="noopener">Twitter</a>
    <a href="https://www.instagram.com/mykell_writes/" target="_blank" rel="noopener">Instagram</a>
  </div>
  <div class="footer-copy">&copy; {{ date('Y') }} Michael Agbozo</div>
</footer>

<script>
  const nav = document.getElementById('nav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 60);
  });

  const reveals = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('on');
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
  reveals.forEach(r => observer.observe(r));
</script>
@stack('scripts')
</body>
</html>
