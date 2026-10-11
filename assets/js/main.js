// ASTAN International — site behaviour
(function () {
  // Mobile navigation
  var header = document.querySelector('.site-header');
  var toggle = document.querySelector('.nav-toggle');
  if (header && toggle) {
    toggle.addEventListener('click', function () {
      var open = header.classList.toggle('nav-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    header.querySelectorAll('.nav a').forEach(function (a) {
      a.addEventListener('click', function () {
        header.classList.remove('nav-open');
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // Reveal-on-scroll
  var items = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
      });
    }, { threshold: 0.12 });
    items.forEach(function (el) { io.observe(el); });
  } else {
    items.forEach(function (el) { el.classList.add('in'); });
  }

  // Contact form status (set by contact.php redirect)
  var params = new URLSearchParams(window.location.search);
  var status = params.get('status');
  if (status) {
    var el = document.getElementById(status === 'sent' ? 'form-ok' : 'form-err');
    if (el) { el.classList.add('show'); el.scrollIntoView({ block: 'center' }); }
  }

  // Pre-select a service when arriving from a service link (contact.html?service=...)
  var svc = params.get('service');
  var select = document.getElementById('service');
  if (svc && select) {
    for (var i = 0; i < select.options.length; i++) {
      if (select.options[i].value === svc) { select.selectedIndex = i; break; }
    }
  }

  // Footer year
  var y = document.getElementById('year');
  if (y) y.textContent = new Date().getFullYear();
})();
