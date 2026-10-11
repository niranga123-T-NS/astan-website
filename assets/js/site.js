// ASTAN International & ANTS Design Ventures — site behaviour
(function () {
  var doc = document.documentElement;
  doc.classList.add('js');

  // Header shadow on scroll
  var header = document.querySelector('[data-header]');
  function onScroll() { if (header) header.classList.toggle('scrolled', window.scrollY > 10); }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // Mobile navigation
  var toggle = document.querySelector('.nav-toggle');
  if (toggle) {
    toggle.addEventListener('click', function () {
      var open = document.body.classList.toggle('nav-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    document.querySelectorAll('.nav a').forEach(function (a) {
      a.addEventListener('click', function () {
        document.body.classList.remove('nav-open');
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // Reveal on scroll
  var items = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    items.forEach(function (el) { io.observe(el); });
  } else {
    items.forEach(function (el) { el.classList.add('in'); });
  }

  // Portfolio filters
  var filters = document.querySelectorAll('[data-filter]');
  if (filters.length) {
    var cards = document.querySelectorAll('.work-card');
    var empty = document.querySelector('[data-filter-empty]');
    var state = { brand: 'all', cat: 'all' };
    var params = new URLSearchParams(location.search);
    if (params.get('brand')) state.brand = params.get('brand');
    function apply() {
      var shown = 0;
      cards.forEach(function (c) {
        var ok = (state.brand === 'all' || c.dataset.brand === state.brand) &&
                 (state.cat === 'all' || c.dataset.cat === state.cat);
        c.classList.toggle('is-hidden', !ok);
        if (ok) shown++;
      });
      filters.forEach(function (f) {
        var t = f.dataset.filter, v = f.dataset.value;
        f.classList.toggle('is-active', state[t] === v);
        // hide categories with no projects for the selected brand
        if (t === 'cat' && v !== 'all') {
          var any = Array.prototype.some.call(cards, function (c) {
            return c.dataset.cat === v && (state.brand === 'all' || c.dataset.brand === state.brand);
          });
          f.hidden = !any;
        }
      });
      if (empty) empty.hidden = shown > 0;
    }
    filters.forEach(function (f) {
      f.addEventListener('click', function () {
        state[f.dataset.filter] = f.dataset.value;
        if (f.dataset.filter === 'brand') state.cat = 'all';
        apply();
      });
    });
    apply();
  }

  // Gallery lightbox
  var links = Array.prototype.slice.call(document.querySelectorAll('[data-lightbox]'));
  if (links.length) {
    var lb = document.createElement('div');
    lb.className = 'lightbox';
    lb.setAttribute('role', 'dialog');
    lb.setAttribute('aria-modal', 'true');
    lb.innerHTML = '<img alt=""><button class="lb-close" aria-label="Close">&times;</button>' +
      '<button class="lb-prev" aria-label="Previous">&#8249;</button><button class="lb-next" aria-label="Next">&#8250;</button>';
    document.body.appendChild(lb);
    var img = lb.querySelector('img'), idx = 0;
    function show(i) {
      idx = (i + links.length) % links.length;
      img.src = links[idx].getAttribute('href');
      img.alt = links[idx].querySelector('img') ? links[idx].querySelector('img').alt : '';
    }
    function close() { lb.classList.remove('open'); document.body.style.overflow = ''; }
    links.forEach(function (a, i) {
      a.addEventListener('click', function (ev) {
        ev.preventDefault(); show(i); lb.classList.add('open'); document.body.style.overflow = 'hidden';
      });
    });
    lb.querySelector('.lb-close').onclick = close;
    lb.querySelector('.lb-prev').onclick = function () { show(idx - 1); };
    lb.querySelector('.lb-next').onclick = function () { show(idx + 1); };
    lb.addEventListener('click', function (ev) { if (ev.target === lb) close(); });
    document.addEventListener('keydown', function (ev) {
      if (!lb.classList.contains('open')) return;
      if (ev.key === 'Escape') close();
      if (ev.key === 'ArrowLeft') show(idx - 1);
      if (ev.key === 'ArrowRight') show(idx + 1);
    });
    if (links.length < 2) { lb.querySelector('.lb-prev').hidden = true; lb.querySelector('.lb-next').hidden = true; }
  }

  // Bring a form result message into view
  var note = document.querySelector('.notice');
  if (note) note.scrollIntoView({ block: 'center' });
})();
