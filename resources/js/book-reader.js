// Flipbook reader for /books/{slug}. PDF.js draws each page in the browser,
// so any uploaded PDF works without converting it to images on the server.
import * as pdfjsLib from 'pdfjs-dist';
// Bundled by Vite as a plain .js worker, since some servers don't send .mjs files as JavaScript.
import PdfWorker from 'pdfjs-dist/build/pdf.worker.min.mjs?worker';

pdfjsLib.GlobalWorkerOptions.workerPort = new PdfWorker();

const reader = document.querySelector('[data-reader]');
const shell = document.querySelector('[data-shell]');
const book = document.querySelector('[data-book]');
const status = document.querySelector('[data-status]');
const counter = document.querySelector('[data-page-count]');
const flipSheet = document.querySelector('[data-flip-sheet]');
const prevButtons = document.querySelectorAll('[data-prev]');
const nextButtons = document.querySelectorAll('[data-next]');
const isMobile = () => window.matchMedia('(max-width: 700px)').matches;

let pdf = null;
let total = 0;
let index = 0;
let locked = false;
let audioContext = null;
const pages = [];
const loading = [];

function pageMarkup(i, side) {
  const inner = pages[i]
    ? '<img src="' + pages[i] + '" alt="Page ' + (i + 1) + '">'
    : '<span class="page-loading">Loading page ' + (i + 1) + '…</span>';

  return '<div class="page ' + side + '">' + inner + '</div>';
}

// Draw page i at the size it is shown (sharp on retina, capped to save memory).
function load(i) {
  if (!loading[i]) {
    loading[i] = pdf.getPage(i + 1).then(async page => {
      const base = page.getViewport({ scale: 1 });
      const ratio = Math.min(window.devicePixelRatio || 1, 2);
      const slotWidth = (isMobile() ? shell.clientWidth : shell.clientWidth / 2) * ratio;
      const slotHeight = shell.clientHeight * ratio;
      const scale = Math.min(slotWidth / base.width, slotHeight / base.height, 2400 / base.height);
      const viewport = page.getViewport({ scale });
      const canvas = document.createElement('canvas');

      canvas.width = Math.floor(viewport.width);
      canvas.height = Math.floor(viewport.height);
      await page.render({ canvas, viewport }).promise;
      page.cleanup();

      const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', .9));
      pages[i] = URL.createObjectURL(blob);

      if (visiblePagesFor().includes(i)) paint();
    }).catch(() => {
      loading[i] = null;
    });
  }

  return loading[i];
}

function preload() {
  const visible = visiblePagesFor();
  const ahead = visible[visible.length - 1];

  [...visible, ahead + 1, ahead + 2, visible[0] - 1]
    .filter(i => i >= 0 && i < total)
    .forEach(load);
}

function visiblePagesFor(currentIndex = index) {
  if (isMobile()) return [currentIndex];
  if (currentIndex === 0) return [0];

  const maxIndex = Math.max(0, total - 2);
  const safeIndex = Math.max(0, Math.min(currentIndex, maxIndex));
  return [safeIndex, Math.min(safeIndex + 1, total - 1)];
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
  flipSheet.innerHTML = pages[sourceIndex] ? '<img src="' + pages[sourceIndex] + '" alt="" aria-hidden="true">' : '';
  void flipSheet.offsetWidth;
  flipSheet.classList.add(direction, 'is-active');
}

function paint() {
  const mobile = isMobile();
  const maxIndex = mobile ? total - 1 : Math.max(0, total - 2);
  index = Math.max(0, Math.min(index, maxIndex));

  book.classList.toggle('is-single', mobile || index === 0 || index === total - 1);

  if (mobile) {
    book.innerHTML = pageMarkup(index, 'single turn-cue');
    counter.textContent = 'Page ' + (index + 1) + ' / ' + total;
  } else if (index === 0) {
    book.innerHTML = pageMarkup(0, 'single turn-cue');
    counter.textContent = 'Cover / ' + total;
  } else {
    const left = index;
    const right = Math.min(index + 1, total - 1);
    book.innerHTML = pageMarkup(left, 'left') + pageMarkup(right, 'right turn-cue');
    counter.textContent = 'Pages ' + (left + 1) + '-' + (right + 1) + ' / ' + total;
  }

  if (!locked) {
    prevButtons.forEach(button => button.disabled = index === 0);
    nextButtons.forEach(button => button.disabled = mobile ? index >= total - 1 : index >= maxIndex);
  }
}

function render() {
  paint();
  preload();
}

function move(direction) {
  if (locked || !pdf) return;
  const step = isMobile() || index === 0 ? 1 : 2;
  const nextIndex = direction === 'next' ? index + step : index - step;
  const mobile = isMobile();
  const maxIndex = mobile ? total - 1 : Math.max(0, total - 2);
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
    paint();
  }, 640);

  setTimeout(() => {
    flipSheet.className = 'flip-sheet';
    flipSheet.innerHTML = '';
    locked = false;
    render();
  }, 1120);
}

// If the browser can't draw the PDF, fall back to its built-in PDF viewer.
function showFallback() {
  reader.innerHTML = '<iframe class="ebook-frame" src="' + reader.dataset.pdf + '#toolbar=1&navpanes=0&view=FitH" title="' + reader.dataset.title.replace(/"/g, '&quot;') + '"></iframe>'
    + '<a class="download-btn" href="' + reader.dataset.pdf + '" download>Download</a>';
}

prevButtons.forEach(button => button.addEventListener('click', () => move('prev')));
nextButtons.forEach(button => button.addEventListener('click', () => move('next')));
document.addEventListener('keydown', event => {
  if (event.key === 'ArrowLeft') move('prev');
  if (event.key === 'ArrowRight') move('next');
});
window.addEventListener('resize', () => {
  if (pdf) render();
});

pdfjsLib.getDocument({ url: reader.dataset.pdf }).promise
  .then(doc => {
    pdf = doc;
    total = doc.numPages;
    status.hidden = true;
    render();
  })
  .catch(error => {
    console.error('Book reader:', error);
    showFallback();
  });
