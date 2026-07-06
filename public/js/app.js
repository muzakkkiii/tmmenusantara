(function () {
  'use strict';
  var RM = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  var scrollBound = false;
  function initScroll() {
    if (scrollBound) return;
    scrollBound = true;
    window.addEventListener('scroll', function () {
      var head = document.getElementById('pubHead');
      if (head) head.classList.toggle('scrolled', window.scrollY > 10);
    }, { passive: true });
  }

  function initNav() {
    var burger = document.getElementById('burger');
    var nav = document.getElementById('nav');
    var scrim = document.getElementById('navScrim');
    function toggleNav(open) {
      if (!nav) return;
      nav.classList.toggle('open', open);
      if (burger) { burger.classList.toggle('x', open); burger.setAttribute('aria-expanded', open ? 'true' : 'false'); }
      if (scrim) scrim.classList.toggle('show', open);
      document.body.classList.toggle('nav-open', open);
      if (!open) { nav.querySelectorAll('.nav-item.open').forEach(function (i) { i.classList.remove('open'); }); }
    }
    if (burger && !burger.dataset.bound) {
      burger.dataset.bound = '1';
      burger.setAttribute('aria-expanded', 'false');
      burger.setAttribute('aria-controls', 'nav');
      burger.addEventListener('click', function () { toggleNav(!nav.classList.contains('open')); });
    }
    if (scrim && !scrim.dataset.bound) {
      scrim.dataset.bound = '1';
      scrim.addEventListener('click', function () { toggleNav(false); });
    }
    var closeBtn = document.getElementById('navClose');
    if (closeBtn && !closeBtn.dataset.bound) {
      closeBtn.dataset.bound = '1';
      closeBtn.addEventListener('click', function () { toggleNav(false); });
    }
    if (nav) {
      var mqMobile = function () { return window.matchMedia('(max-width:900px)').matches; };
      nav.querySelectorAll('a').forEach(function (a) {
        if (a.dataset.bound) return;
        a.dataset.bound = '1';
        var item = a.parentElement;
        var isParent = a.classList.contains('nav-link') && item && item.classList.contains('nav-item') && item.querySelector(':scope > .dropdown');
        a.addEventListener('click', function (e) {
          if (isParent && mqMobile()) {
            e.preventDefault();
            var wasOpen = item.classList.contains('open');
            nav.querySelectorAll('.nav-item.open').forEach(function (i) { if (i !== item) i.classList.remove('open'); });
            item.classList.toggle('open', !wasOpen);
            return;
          }
          toggleNav(false);
        });
      });
    }
    if (!document.body.dataset.navEsc) {
      document.body.dataset.navEsc = '1';
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && nav && nav.classList.contains('open')) toggleNav(false);
      });
    }
  }

  // Expose dropdown state to assistive tech (menus open on hover/focus via CSS).
  function initDropdownAria() {
    document.querySelectorAll('.nav-item').forEach(function (item) {
      var link = item.querySelector(':scope > .nav-link');
      var dd = item.querySelector(':scope > .dropdown');
      if (!link || !dd || link.dataset.ddBound) return;
      link.dataset.ddBound = '1';
      link.setAttribute('aria-haspopup', 'true');
      link.setAttribute('aria-expanded', 'false');
      function set(v) { link.setAttribute('aria-expanded', v ? 'true' : 'false'); }
      item.addEventListener('mouseenter', function () { set(true); });
      item.addEventListener('mouseleave', function () { set(false); });
      item.addEventListener('focusin', function () { set(true); });
      item.addEventListener('focusout', function (e) { if (!item.contains(e.relatedTarget)) set(false); });
    });
  }

  function initReveal() {
    var els = document.querySelectorAll('.reveal:not(.in)');
    if (RM || !('IntersectionObserver' in window)) {
      els.forEach(function (el) { el.classList.add('in'); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
      });
    }, { threshold: 0.12 });
    els.forEach(function (el) { io.observe(el); });
  }

  function animateCount(el) {
    var target = parseFloat(el.getAttribute('data-count'));
    if (isNaN(target)) return;
    var suffix = el.getAttribute('data-suffix') || '';
    var prefix = el.getAttribute('data-prefix') || '';
    function render(v) { el.textContent = prefix + Math.round(v).toLocaleString('id-ID') + suffix; }
    if (RM) { render(target); return; }
    var dur = 1400, start = null;
    function step(ts) {
      if (!start) start = ts;
      var p = Math.min((ts - start) / dur, 1);
      render(target * (1 - Math.pow(1 - p, 3)));
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }
  function initCount() {
    var els = document.querySelectorAll('[data-count]:not([data-counted])');
    if (!els.length) return;
    if (!('IntersectionObserver' in window)) {
      els.forEach(function (el) { el.setAttribute('data-counted', '1'); animateCount(el); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.setAttribute('data-counted', '1'); animateCount(e.target); io.unobserve(e.target); }
      });
    }, { threshold: 0.4 });
    els.forEach(function (el) { io.observe(el); });
  }

  function cellVal(row, idx) {
    var cell = row.cells[idx];
    if (!cell) return { s: '', n: null };
    var raw = cell.getAttribute('data-sort');
    if (raw !== null) {
      if (/^-?\d+(\.\d+)?$/.test(raw)) return { s: raw, n: parseFloat(raw) };
      return { s: raw.toLowerCase(), n: null };
    }
    var txt = (cell.textContent || '').trim();
    return { s: txt.toLowerCase(), n: null };
  }
  function initTableSort() {
    document.querySelectorAll('table.sortable').forEach(function (table) {
      if (table.dataset.sortBound) return;
      table.dataset.sortBound = '1';
      var ths = table.querySelectorAll('thead th');
      ths.forEach(function (th, idx) {
        th.setAttribute('role', 'button');
        th.setAttribute('tabindex', '0');
        th.setAttribute('aria-sort', 'none');
        if (!th.getAttribute('title')) th.setAttribute('title', 'Urutkan berdasarkan kolom ini');
        function doSort() {
          var tbody = table.tBodies[0];
          if (!tbody) return;
          var rows = Array.prototype.slice.call(tbody.rows).filter(function (r) { return r.cells.length > 1; });
          if (rows.length < 2) return;
          var asc = th.getAttribute('data-dir') !== 'asc';
          ths.forEach(function (o) { o.removeAttribute('data-dir'); o.classList.remove('sort-asc', 'sort-desc'); o.setAttribute('aria-sort', 'none'); });
          th.setAttribute('data-dir', asc ? 'asc' : 'desc');
          th.classList.add(asc ? 'sort-asc' : 'sort-desc');
          th.setAttribute('aria-sort', asc ? 'ascending' : 'descending');
          rows.sort(function (a, b) {
            var x = cellVal(a, idx), y = cellVal(b, idx);
            if (x.n !== null && y.n !== null) return asc ? x.n - y.n : y.n - x.n;
            return asc ? x.s.localeCompare(y.s, 'id') : y.s.localeCompare(x.s, 'id');
          });
          rows.forEach(function (r) { tbody.appendChild(r); });
        }
        th.addEventListener('click', doSort);
        th.addEventListener('keydown', function (e) {
          if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); doSort(); }
        });
      });
    });
  }

  function initFormLoading() {
    document.querySelectorAll('form button[data-loading-text]').forEach(function (btn) {
      var form = btn.closest('form');
      if (!form || form.dataset.bound) return;
      form.dataset.bound = '1';
      form.addEventListener('submit', function () {
        btn.disabled = true;
        btn.innerHTML = btn.getAttribute('data-loading-text');
        btn.style.opacity = '.7';
      });
    });
  }

  function initScrollTop() {
    var btn = document.getElementById('scrollTop');
    if (!btn || btn.dataset.bound) return;
    btn.dataset.bound = '1';
    window.addEventListener('scroll', function () {
      if (window.scrollY > 400) { btn.classList.add('visible'); } else { btn.classList.remove('visible'); }
    }, { passive: true });
  }

  // Reusable accessible modal (Alpine) — replaces duplicated inline modal state.
  // Handles focus move-in, focus restore, Tab focus-trap and scroll lock.
  function registerModal() {
    if (!window.Alpine || window.__modalRegistered) return;
    window.__modalRegistered = true;
    window.Alpine.data('modal', function (evt) {
      return {
        open: false,
        _prev: null,
        init: function () {
          var self = this;
          if (evt) window.addEventListener(evt, function () { self.show(); });
        },
        show: function () {
          this._prev = document.activeElement;
          this.open = true;
          document.body.classList.add('modal-open');
          var self = this;
          this.$nextTick(function () {
            var p = self.$refs.panel;
            if (!p) return;
            var f = p.querySelector('input:not([type=hidden]),select,textarea,a[href],button:not(.km-close)');
            (f || p).focus();
          });
        },
        close: function () {
          this.open = false;
          document.body.classList.remove('modal-open');
          if (this._prev && this._prev.focus) this._prev.focus();
        },
        trap: function (e) {
          if (!this.open || e.key !== 'Tab') return;
          var p = this.$refs.panel;
          if (!p) return;
          var f = Array.prototype.filter.call(
            p.querySelectorAll('a[href],button,input:not([type=hidden]),select,textarea,[tabindex]:not([tabindex="-1"])'),
            function (el) { return el.offsetParent !== null; }
          );
          if (!f.length) return;
          var first = f[0], last = f[f.length - 1];
          if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
          else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        }
      };
    });
  }
  document.addEventListener('alpine:init', registerModal);

  function init() {
    initScroll(); initNav(); initDropdownAria(); initReveal(); initCount();
    initScrollTop(); initTableSort(); initFormLoading();
  }
  document.addEventListener('DOMContentLoaded', init);
  document.addEventListener('livewire:navigated', init);
  if (document.readyState !== 'loading') init();
})();
