@extends('layouts.app')

@section('title', 'Michael Agbozo — IT Professional, Web Developer & Designer')

@section('content')

<!-- HERO -->
<section class="hero">
  <div class="hero-left">
    <div>
      <div class="hero-tag"><div class="hero-tag-dot"></div> Available for projects</div>
      <h1 class="hero-h1">
        Strategic<br/>
        <span class="outline">Brands</span> &amp;<br/>
        <span class="accent">Solid</span><br/>
        Systems.
      </h1>
      <p class="hero-desc">IT professional, web developer, and designer. I build WordPress sites and Laravel applications end-to-end, manage IT infrastructure, and craft brand identities that last.</p>
      <div class="hero-btns">
        <a href="#work" class="btn-orange">View Work</a>
        <a href="#contact" class="btn-outline">Get In Touch</a>
      </div>
    </div>
    <div class="hero-stats">
      <div class="hero-stat">
        <div class="hero-stat-num">6<span>+</span></div>
        <div class="hero-stat-label">Years Design</div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-num">20<span>+</span></div>
        <div class="hero-stat-label">Projects Done</div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-num">3<span>+</span></div>
        <div class="hero-stat-label">Years Dev</div>
      </div>
    </div>
  </div>
  <div class="hero-right">
    {{-- Replace with: <img src="{{ asset('images/michael.jpg') }}" alt="Michael Agbozo"> --}}
    <div class="hero-photo-placeholder">
      <div class="hero-initials">MK</div>
    </div>
    <div class="hero-floating-badge">
      <div class="hfb-label">Based in</div>
      <div class="hfb-value">Ghana &#127468;&#127469;</div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="section" id="about">
  <div class="section-tag"><div class="section-tag-dot"></div> About Me</div>
  <h2 class="section-title">Building things that<br/><span class="outline">actually</span> <span class="accent">work.</span></h2>
  <div class="about-grid reveal">
    <div class="about-body">
      <p>With 6+ years in design, 3+ years in WordPress development, and growing experience in backend engineering, I focus on building systems that combine solid engineering with design sensibility.</p>
      <p>My experience spans multiple domains — I independently develop and deploy WordPress websites, contribute to custom backend development with Laravel, manage IT operations and systems administration across organizations, and design brand identities and digital materials.</p>
      <p>I work within Four Corners Community Service (FCCS) and La Necar Logistics, handling IT systems, web development, and internal tools — bringing both technical depth and design sensibility to every project.</p>
    </div>
    <div class="skills-stack">
      <div class="skill-row">
        <span class="skill-name">Development</span>
        <div class="skill-tags-inline">
          <span class="s-tag">Laravel</span>
          <span class="s-tag">WordPress</span>
          <span class="s-tag">Livewire</span>
          <span class="s-tag">PHP</span>
        </div>
      </div>
      <div class="skill-row">
        <span class="skill-name">Frontend</span>
        <div class="skill-tags-inline">
          <span class="s-tag">Bootstrap</span>
          <span class="s-tag">HTML/CSS</span>
          <span class="s-tag">JavaScript</span>
        </div>
      </div>
      <div class="skill-row">
        <span class="skill-name">Design</span>
        <div class="skill-tags-inline">
          <span class="s-tag">Brand Identity</span>
          <span class="s-tag">Figma</span>
          <span class="s-tag">Illustrator</span>
        </div>
      </div>
      <div class="skill-row">
        <span class="skill-name">IT &amp; Systems</span>
        <div class="skill-tags-inline">
          <span class="s-tag">Infrastructure</span>
          <span class="s-tag">Sys Admin</span>
          <span class="s-tag">AI Tools</span>
        </div>
      </div>
      <div class="skill-row">
        <span class="skill-name">No-Code</span>
        <div class="skill-tags-inline">
          <span class="s-tag">Webflow</span>
          <span class="s-tag">Elementor</span>
          <span class="s-tag">WooCommerce</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="section" id="services">
  <div class="section-tag"><div class="section-tag-dot"></div> What I Do</div>
  <h2 class="section-title">Services that <span class="accent">deliver</span><br/><span class="outline">real results.</span></h2>
  <div class="services-grid reveal">
    <div class="service-card">
      <div class="service-num">01</div>
      <div class="service-line"></div>
      <div class="service-name">Web Development</div>
      <p class="service-desc">WordPress websites and Laravel applications built end-to-end. Custom solutions — no bloated templates. Complete ownership from concept to launch and long-term support.</p>
    </div>
    <div class="service-card">
      <div class="service-num">02</div>
      <div class="service-line"></div>
      <div class="service-name">Brand Identity &amp; Design</div>
      <p class="service-desc">Visual identity systems that communicate with precision — logos, color systems, typography, and digital materials. Brands that are memorable and built to last.</p>
    </div>
    <div class="service-card">
      <div class="service-num">03</div>
      <div class="service-line"></div>
      <div class="service-name">IT Systems &amp; Infrastructure</div>
      <p class="service-desc">End-to-end IT management, systems administration, and internal tool development. Efficient, clean, and built to scale with the operation.</p>
    </div>
  </div>
</section>

<!-- WORK -->
<section class="section" id="work">
  <div class="work-header reveal">
    <div>
      <div class="section-tag"><div class="section-tag-dot"></div> Portfolio</div>
      <h2 class="section-title">Selected <span class="accent">work.</span></h2>
    </div>
  </div>
  <div class="work-list reveal">
    @foreach($projects as $project)
    <a href="{{ $project->url ?: '#' }}" {{ $project->url ? 'target="_blank" rel="noopener"' : '' }} class="work-item">
      <div class="work-item-num">{{ $project->num }}</div>
      <div>
        <div class="work-item-title">{{ $project->title }}</div>
        <div class="work-item-meta">{{ $project->meta }}</div>
      </div>
      <div class="work-item-tags">
        @foreach($project->tags ?? [] as $tag)
        <span class="w-tag">{{ $tag }}</span>
        @endforeach
      </div>
      <div class="work-arrow">↗</div>
    </a>
    @endforeach
  </div>
</section>

<!-- SOCIAL MEDIA DESIGNS -->
<section class="section" id="designs">
  <div class="design-intro reveal">
    <div>
      <div class="section-tag"><div class="section-tag-dot"></div> Social Media Design</div>
      <h2 class="section-title">Design <span class="accent">spotlight.</span></h2>
    </div>
  </div>
  <div class="design-grid reveal">
    @foreach($designs as $design)
    <div class="design-item">
      <img src="{{ $design['src'] }}" alt="{{ $design['alt'] }}" loading="lazy"/>
      <div class="design-overlay"></div>
    </div>
    @endforeach
  </div>
</section>

<!-- CONTACT -->
<section class="section" id="contact">
  <div class="section-tag"><div class="section-tag-dot"></div> Contact</div>
  <h2 class="section-title">Let's build something<br/><span class="accent">exceptional.</span></h2>
  <div class="contact-inner">
    <div class="reveal">
      <p class="contact-big-text">Have a project?<br/>Let's make it <span>real.</span></p>
      <p style="color:var(--muted);font-size:.93rem;line-height:1.85;margin-bottom:.5rem">Whether you need a solid website, a brand that stands out, or a system that actually works — reach out and let's talk about it.</p>
      <div class="contact-details">
        <div class="c-detail">
          <div class="c-icon">✉</div>
          <div>
            <div class="c-text-label">Email</div>
            <div class="c-text-val">agbozomykell8@gmail.com</div>
          </div>
        </div>
        <div class="c-detail">
          <div class="c-icon">✆</div>
          <div>
            <div class="c-text-label">Phone</div>
            <div class="c-text-val">0248581824</div>
          </div>
        </div>
        <div class="c-detail">
          <div class="c-icon">◯</div>
          <div>
            <div class="c-text-label">Location</div>
            <div class="c-text-val">Ghana — Available remotely</div>
          </div>
        </div>
      </div>
    </div>
    <div class="reveal">
      <form class="contact-form" method="POST" action="{{ route('contact.send') }}">
        @csrf
        @if(session('success'))
          <div style="color:var(--orange);font-size:.85rem;padding:.75rem 1rem;border:1px solid var(--orange);border-radius:8px;">
            {{ session('success') }}
          </div>
        @endif
        <div class="form-row">
          <div>
            <label class="f-label">Name</label>
            <input class="f-input" type="text" name="name" placeholder="Your name" value="{{ old('name') }}" required/>
          </div>
          <div>
            <label class="f-label">Email</label>
            <input class="f-input" type="email" name="email" placeholder="you@email.com" value="{{ old('email') }}" required/>
          </div>
        </div>
        <div>
          <label class="f-label">Subject</label>
          <input class="f-input" type="text" name="subject" placeholder="Project type or inquiry" value="{{ old('subject') }}" required/>
        </div>
        <div>
          <label class="f-label">Message</label>
          <textarea class="f-textarea" name="message" placeholder="Tell me about your project..." required>{{ old('message') }}</textarea>
        </div>
        <button class="f-submit" type="submit">Send Message →</button>
      </form>
    </div>
  </div>
</section>

@endsection
