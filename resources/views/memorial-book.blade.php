<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Dadaa Kate Dzidzornu Nyamadi Funeral Ebook</title>
<meta name="description" content="Dadaa Kate Dzidzornu Nyamadi funeral ebook shared with family and friends."/>
<meta name="robots" content="noindex, follow"/>
<link rel="canonical" href="{{ route('memorial.book') }}"/>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"/>
<style>
  *{box-sizing:border-box}
  html,body{margin:0;width:100%;height:100%;background:#111;color:#fff;font-family:Arial,sans-serif;overflow:hidden}
  body{background:radial-gradient(circle at 50% 12%,#36323a 0,#171719 42%,#080809 100%)}
  button{font:inherit}
  .ebook-page{position:fixed;inset:0;display:flex;align-items:center;justify-content:center;padding:18px;background:linear-gradient(90deg,rgba(0,0,0,.42),transparent 22%,transparent 78%,rgba(0,0,0,.42))}
  .book-shell{position:relative;width:min(94vw,1120px);height:min(88vh,820px);display:flex;align-items:center;justify-content:center;perspective:1800px}
  .book{
    position:relative;
    width:100%;
    height:100%;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:0;
    filter:drop-shadow(0 28px 42px rgba(0,0,0,.48));
  }
  .book.is-single{
    display:flex;
    justify-content:center;
  }
  .book.is-single .page.single{
    width:50%;
  }
  .page{
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    min-width:0;
    height:100%;
    overflow:hidden;
    background:#f8f5ee;
  }
  .page.left{border-radius:8px 0 0 8px;box-shadow:inset -18px 0 28px rgba(0,0,0,.12)}
  .page.right{border-radius:0 8px 8px 0;box-shadow:inset 18px 0 28px rgba(0,0,0,.12)}
  .page.single{grid-column:1 / -1;border-radius:8px;box-shadow:inset 0 0 22px rgba(0,0,0,.08)}
  .page.turn-cue::before{
    content:"";
    position:absolute;
    right:0;
    bottom:0;
    z-index:4;
    width:74px;
    height:74px;
    background:linear-gradient(135deg,rgba(255,255,255,0) 0 49%,rgba(210,205,194,.96) 50%,#fffaf0 66%,rgba(118,95,76,.2) 100%);
    clip-path:polygon(100% 0,100% 100%,0 100%);
    filter:drop-shadow(-7px -7px 9px rgba(0,0,0,.2));
    transition:width .22s ease,height .22s ease,filter .22s ease;
    pointer-events:none;
  }
  .page.turn-cue::after{
    content:"";
    position:absolute;
    right:13px;
    bottom:13px;
    z-index:5;
    width:34px;
    height:34px;
    border-right:1px solid rgba(80,64,49,.24);
    border-bottom:1px solid rgba(80,64,49,.2);
    transform:rotate(45deg);
    pointer-events:none;
  }
  .book-shell:hover .page.turn-cue::before{width:96px;height:96px;filter:drop-shadow(-10px -10px 13px rgba(0,0,0,.24))}
  .book::after{
    content:"";
    position:absolute;
    top:0;
    bottom:0;
    left:50%;
    width:2px;
    transform:translateX(-50%);
    background:linear-gradient(90deg,rgba(0,0,0,.22),rgba(255,255,255,.22),rgba(0,0,0,.18));
    z-index:3;
  }
  .page.single + .page,.book.is-single::after{display:none}
  .page img{display:block;max-width:100%;max-height:100%;width:auto;height:auto;user-select:none;-webkit-user-drag:none}
  .flip-sheet{
    position:absolute;
    top:0;
    bottom:0;
    z-index:8;
    display:none;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    background:#f8f5ee;
    backface-visibility:visible;
    transform-style:preserve-3d;
    box-shadow:0 22px 38px rgba(0,0,0,.24);
    pointer-events:none;
  }
  .flip-sheet img{display:block;max-width:100%;max-height:100%;width:auto;height:auto}
  .flip-sheet::after{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(90deg,rgba(255,255,255,.3),rgba(0,0,0,.24));
    opacity:.58;
    pointer-events:none;
  }
  .flip-sheet.next{
    left:50%;
    width:50%;
    border-radius:0 8px 8px 0;
    transform-origin:left center;
    animation:flipNext 1.08s cubic-bezier(.18,.74,.18,1) both;
  }
  .flip-sheet.prev{
    left:0;
    width:50%;
    border-radius:8px 0 0 8px;
    transform-origin:right center;
    animation:flipPrev 1.08s cubic-bezier(.18,.74,.18,1) both;
  }
  .flip-sheet.is-active{display:flex}
  @keyframes flipNext{
    0%{transform:translateX(0) rotateY(0deg) scaleX(1);filter:brightness(1)}
    32%{transform:translateX(-4%) rotateY(-34deg) scaleX(.98);filter:brightness(.95)}
    68%{transform:translateX(-20%) rotateY(-76deg) scaleX(.94);filter:brightness(.82)}
    100%{transform:translateX(-48%) rotateY(-118deg) scaleX(.9);filter:brightness(.7)}
  }
  @keyframes flipPrev{
    0%{transform:translateX(0) rotateY(0deg) scaleX(1);filter:brightness(1)}
    32%{transform:translateX(4%) rotateY(34deg) scaleX(.98);filter:brightness(.95)}
    68%{transform:translateX(20%) rotateY(76deg) scaleX(.94);filter:brightness(.82)}
    100%{transform:translateX(48%) rotateY(118deg) scaleX(.9);filter:brightness(.7)}
  }
  .tap-zone{position:absolute;top:0;bottom:0;width:42%;z-index:5;border:0;background:transparent;color:transparent;cursor:pointer}
  .tap-zone.prev{left:0}
  .tap-zone.next{right:0}
  .corner-turn{
    position:absolute;
    right:0;
    bottom:0;
    z-index:11;
    width:170px;
    height:170px;
    border:0;
    background:transparent;
    color:transparent;
    cursor:pointer;
  }
  .nav-btn{
    position:fixed;
    top:50%;
    z-index:12;
    width:46px;
    height:46px;
    border-radius:999px;
    border:1px solid rgba(255,255,255,.18);
    background:rgba(0,0,0,.56);
    color:#fff;
    cursor:pointer;
    box-shadow:0 10px 26px rgba(0,0,0,.24);
  }
  .nav-btn:hover{background:rgba(232,83,26,.92)}
  .nav-btn:disabled{opacity:.25;cursor:not-allowed}
  .nav-btn.prev{left:18px}
  .nav-btn.next{right:18px}
  .page-count{
    position:fixed;
    left:50%;
    bottom:18px;
    z-index:12;
    transform:translateX(-50%);
    padding:10px 14px;
    border-radius:999px;
    background:rgba(0,0,0,.58);
    color:rgba(255,255,255,.86);
    font-size:13px;
    font-weight:700;
    letter-spacing:.02em;
    box-shadow:0 10px 26px rgba(0,0,0,.22);
  }
  .download-btn{
    position:fixed;
    right:18px;
    bottom:18px;
    z-index:10;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:46px;
    padding:0 18px;
    border-radius:999px;
    background:#e8531a;
    color:#fff;
    text-decoration:none;
    font-size:14px;
    font-weight:700;
    box-shadow:0 10px 28px rgba(0,0,0,.32);
  }
  .download-btn:hover{background:#ff6a2a}
  .empty{max-width:560px;padding:24px;border-radius:8px;background:rgba(0,0,0,.5);line-height:1.5;text-align:center}
  .ebook-frame{display:block;width:100%;height:100%;border:0;background:#fff}
  @media(max-width:700px){
    .ebook-page{padding:12px 10px 76px}
    .book-shell{width:100%;height:100%}
    .book{grid-template-columns:1fr}
    .book.is-single .page.single{width:100%}
    .book::after{display:none}
    .page.left,.page.right{display:none}
    .page.single{display:flex;grid-column:1;border-radius:8px}
    .flip-sheet.next,.flip-sheet.prev{left:0;width:100%;border-radius:8px}
    .flip-sheet.next{transform-origin:left center}
    .flip-sheet.prev{transform-origin:right center}
    .corner-turn{width:150px;height:150px}
    .page.turn-cue::before{width:62px;height:62px}
    .book-shell:hover .page.turn-cue::before{width:78px;height:78px}
    .nav-btn{top:auto;bottom:14px;width:44px;height:44px}
    .nav-btn.prev{left:14px}
    .nav-btn.next{left:68px;right:auto}
    .page-count{bottom:14px;font-size:12px;padding:9px 12px}
    .download-btn{right:14px;bottom:14px;min-height:44px;padding:0 14px;font-size:13px}
  }
</style>
</head>
<body>
<main class="ebook-page">
  @if(count($pages))
    <div class="book-shell">
      <button class="tap-zone prev" type="button" aria-label="Previous page" data-prev>Previous</button>
      <div class="book" data-book></div>
      <div class="flip-sheet" data-flip-sheet aria-hidden="true"></div>
      <button class="tap-zone next" type="button" aria-label="Next page" data-next>Next</button>
      <button class="corner-turn" type="button" aria-label="Turn page from bottom corner" data-next>Turn page</button>
    </div>
    <button class="nav-btn prev" type="button" aria-label="Previous page" data-prev>&larr;</button>
    <button class="nav-btn next" type="button" aria-label="Next page" data-next>&rarr;</button>
    <div class="page-count" data-page-count></div>
  @else
    <iframe
      class="ebook-frame"
      src="{{ $bookUrl }}#toolbar=1&navpanes=0&view=FitH"
      title="Dadaa Kate Dzidzornu Nyamadi Funeral Ebook"
    ></iframe>
  @endif
  <a class="download-btn" href="{{ $bookUrl }}" download>Download</a>
</main>
@if(count($pages))
<script>
  const pages = @json($pages);
  const book = document.querySelector('[data-book]');
  const counter = document.querySelector('[data-page-count]');
  const flipSheet = document.querySelector('[data-flip-sheet]');
  const prevButtons = document.querySelectorAll('[data-prev]');
  const nextButtons = document.querySelectorAll('[data-next]');
  const isMobile = () => window.matchMedia('(max-width: 700px)').matches;
  let index = 0;
  let locked = false;
  let audioContext = null;

  function pageMarkup(src, side, number) {
    return '<div class="page ' + side + '"><img src="' + src + '" alt="Page ' + number + '" loading="' + (number <= 2 ? 'eager' : 'lazy') + '"></div>';
  }

  function visiblePagesFor(currentIndex = index) {
    if (isMobile()) return [currentIndex];
    if (currentIndex === 0) return [0];

    const maxIndex = Math.max(0, pages.length - 2);
    const safeIndex = Math.max(0, Math.min(currentIndex, maxIndex));
    return [safeIndex, Math.min(safeIndex + 1, pages.length - 1)];
  }

  function playTurnSound() {
    try {
      audioContext = audioContext || new (window.AudioContext || window.webkitAudioContext)();
      const now = audioContext.currentTime;
      const duration = .34;
      const noiseSize = Math.floor(audioContext.sampleRate * duration);
      const buffer = audioContext.createBuffer(1, noiseSize, audioContext.sampleRate);
      const data = buffer.getChannelData(0);

      for (let i = 0; i < noiseSize; i++) {
        const t = i / noiseSize;
        data[i] = (Math.random() * 2 - 1) * Math.pow(1 - t, 1.7);
      }

      const noise = audioContext.createBufferSource();
      const filter = audioContext.createBiquadFilter();
      const gain = audioContext.createGain();

      noise.buffer = buffer;
      filter.type = 'bandpass';
      filter.frequency.setValueAtTime(1050, now);
      filter.frequency.exponentialRampToValueAtTime(2600, now + duration);
      filter.Q.value = .9;
      gain.gain.setValueAtTime(0.0001, now);
      gain.gain.exponentialRampToValueAtTime(.16, now + .035);
      gain.gain.exponentialRampToValueAtTime(0.0001, now + duration);

      noise.connect(filter);
      filter.connect(gain);
      gain.connect(audioContext.destination);
      noise.start(now);
      noise.stop(now + duration);
    } catch {
      // Some browsers block audio until a direct tap/click; the next tap will retry.
    }
  }

  function startFlip(direction, fromIndex) {
    const visible = visiblePagesFor(fromIndex);
    const sourceIndex = isMobile()
      ? fromIndex
      : direction === 'next'
        ? visible[visible.length - 1]
        : visible[0];

    flipSheet.className = 'flip-sheet';
    flipSheet.innerHTML = '<img src="' + pages[sourceIndex] + '" alt="" aria-hidden="true">';
    void flipSheet.offsetWidth;
    flipSheet.classList.add(direction, 'is-active');
  }

  function render() {
    const mobile = isMobile();
    const maxIndex = mobile ? pages.length - 1 : Math.max(0, pages.length - 2);
    index = Math.max(0, Math.min(index, maxIndex));

    book.classList.toggle('is-single', mobile || index === 0 || index === pages.length - 1);

    if (mobile) {
      book.innerHTML = pageMarkup(pages[index], 'single turn-cue', index + 1);
      counter.textContent = 'Page ' + (index + 1) + ' / ' + pages.length;
    } else if (index === 0) {
      book.innerHTML = pageMarkup(pages[0], 'single turn-cue', 1);
      counter.textContent = 'Cover / ' + pages.length;
    } else {
      const left = index;
      const right = Math.min(index + 1, pages.length - 1);
      book.innerHTML = pageMarkup(pages[left], 'left', left + 1) + pageMarkup(pages[right], 'right turn-cue', right + 1);
      counter.textContent = 'Pages ' + (left + 1) + '-' + (right + 1) + ' / ' + pages.length;
    }

    prevButtons.forEach(button => button.disabled = index === 0);
    nextButtons.forEach(button => button.disabled = mobile ? index >= pages.length - 1 : index >= maxIndex);
  }

  function move(direction) {
    if (locked) return;
    const step = isMobile() || index === 0 ? 1 : 2;
    const nextIndex = direction === 'next' ? index + step : index - step;
    const mobile = isMobile();
    const maxIndex = mobile ? pages.length - 1 : Math.max(0, pages.length - 2);
    const safeNextIndex = Math.max(0, Math.min(nextIndex, maxIndex));
    if (safeNextIndex === index) return;

    const fromIndex = index;
    locked = true;
    prevButtons.forEach(button => button.disabled = true);
    nextButtons.forEach(button => button.disabled = true);
    startFlip(direction, fromIndex);
    playTurnSound();

    setTimeout(() => {
      index = safeNextIndex;
      render();
    }, 640);

    setTimeout(() => {
      flipSheet.className = 'flip-sheet';
      flipSheet.innerHTML = '';
      locked = false;
      render();
    }, 1120);
  }

  prevButtons.forEach(button => button.addEventListener('click', () => move('prev')));
  nextButtons.forEach(button => button.addEventListener('click', () => move('next')));
  document.addEventListener('keydown', event => {
    if (event.key === 'ArrowLeft') move('prev');
    if (event.key === 'ArrowRight') move('next');
  });
  window.addEventListener('resize', () => render());
  render();
</script>
@endif
</body>
</html>
