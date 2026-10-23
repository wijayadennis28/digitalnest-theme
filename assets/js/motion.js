(function () {
  'use strict';

  var docEl = document.documentElement;
  var header = document.querySelector('.knpo-header');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)');
  var hasGsap = !!window.gsap;
  var hasST = hasGsap && !!window.ScrollTrigger;
  var hasSplit = hasGsap && !!window.SplitText;
  var lenis = null;

  window.knpoRevealsReady = true;

  // Set this before ScrollTrigger enables: it captures the value once and restores it after every refresh.
  if ('scrollRestoration' in history) history.scrollRestoration = 'manual';

  if (hasST) {
    gsap.registerPlugin(ScrollTrigger);
    ScrollTrigger.config({ ignoreMobileResize: true });
  }
  if (hasSplit) gsap.registerPlugin(SplitText);

  /* ---------------------------------------------------------------- reveals */

  var revealObserver = null;
  var pageReveals = [];

  if ('IntersectionObserver' in window) {
    revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('knpo-reveal-in');
        revealObserver.unobserve(entry.target);
      });
    }, { rootMargin: '0px 0px -20% 0px' });
  }

  function observeReveals(scope) {
    if (!revealObserver || !scope) return;
    var els = scope.querySelectorAll('.knpo-reveal, .knpo-stagger, .knpo-mask-reveal');
    els.forEach(function (el) {
      if (el.classList.contains('knpo-reveal-in')) return;
      revealObserver.observe(el);
      if (scope !== document.querySelector('footer')) pageReveals.push(el);
    });
  }

  // The footer lives outside the Barba container, so it keeps one persistent observer.
  observeReveals(document.querySelector('footer'));

  /* ------------------------------------------------------- progress fallback */

  if (docEl.classList.contains('knpo-no-st')) {
    var bar = document.querySelector('.nest-progress');
    if (bar) {
      var progressTick = false;
      var updateProgress = function () {
        var max = docEl.scrollHeight - window.innerHeight;
        var ratio = max > 0 ? Math.min(window.pageYOffset / max, 1) : 0;
        bar.style.transform = 'scaleX(' + ratio + ')';
        progressTick = false;
      };
      window.addEventListener('scroll', function () {
        if (progressTick) return;
        progressTick = true;
        requestAnimationFrame(updateProgress);
      }, { passive: true });
      window.addEventListener('resize', updateProgress, { passive: true });
      updateProgress();
    }
  }

  /* ----------------------------------------------------------------- header */

  var headerHidden = false;
  var lastY = window.pageYOffset || 0;

  function setHeaderHidden(hidden) {
    if (!header || hidden === headerHidden) return;
    headerHidden = hidden;
    header.classList.toggle('knpo-header-hidden', hidden);
  }

  function menuOpen() {
    return !!(header && header.querySelector('details[open]'));
  }

  function focusInHeader() {
    return !!(header && header.contains(document.activeElement));
  }

  function closeMenu() {
    if (!header) return;
    header.querySelectorAll('details[open]').forEach(function (details) { details.open = false; });
  }

  function updateHeader() {
    var y = window.pageYOffset || 0;
    // Reveals follow scroll direction; the 4px delta ignores trackpad jitter.
    if (Math.abs(y - lastY) > 4) docEl.classList.toggle('knpo-scroll-up', y < lastY);
    if (!header) { lastY = y; return; }
    if (reduce.matches || docEl.classList.contains('knpo-transitioning') || menuOpen() || focusInHeader() || y < 80 || y < lastY - 4) {
      setHeaderHidden(false);
    } else if (y > 120 && y > lastY + 4) {
      setHeaderHidden(true);
    }
    lastY = y;
  }

  var headerTick = false;
  window.addEventListener('scroll', function () {
    if (headerTick) return;
    headerTick = true;
    requestAnimationFrame(function () {
      headerTick = false;
      updateHeader();
    });
  }, { passive: true });

  if (header) {
    document.addEventListener('focusin', function (event) {
      if (header.contains(event.target)) setHeaderHidden(false);
    });
    header.querySelectorAll('details').forEach(function (details) {
      details.addEventListener('toggle', function () {
        if (details.open) setHeaderHidden(false);
      });
    });
  }

  /* ------------------------------------------------------------------ lenis */

  if (window.Lenis) {
    lenis = new Lenis({
      duration: 1.2,
      smoothWheel: true,
      anchors: true,
      autoRaf: false,
      respectReducedMotion: true
    });

    if (hasST) {
      lenis.on('scroll', ScrollTrigger.update);
      gsap.ticker.add(function (time) { lenis.raf(time * 1000); });
    } else {
      var raf = function (time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
      };
      requestAnimationFrame(raf);
    }
  }

  /* -------------------------------------------------------------- page state */

  var pageCtx = null;
  var pageMM = null;
  var splits = [];

  function refresh() {
    if (hasST) ScrollTrigger.refresh();
  }

  function markSplitDone(root) {
    if (!root) return;
    root.querySelectorAll('[data-split], h2.nest-display-sm, h2.nest-display-md').forEach(function (el) {
      el.classList.add('knpo-split-done');
    });
  }

  function initPage(root) {
    if (!root) return;
    if (pageCtx) destroyPage();

    observeReveals(root);
    initMagnetics(root);
    initRipples(root);
    if (window.knpoInitJam) window.knpoInitJam(root);

    if (!hasGsap || !hasST) {
      markSplitDone(root);
      return;
    }

    pageMM = gsap.matchMedia();
    pageCtx = gsap.context(function () {
      initHero(root);
      initSplit(root);
      initScrub(root);
      initSpine(root);
      initThumbs(root);
    }, root);

    refresh();
  }

  function destroyPage() {
    if (pageMM) {
      pageMM.revert();
      pageMM = null;
    }
    splits.forEach(function (split) {
      try { split.revert(); } catch (error) {}
    });
    splits = [];
    if (pageCtx) {
      pageCtx.revert();
      pageCtx = null;
    }
    if (revealObserver) {
      pageReveals.forEach(function (el) { revealObserver.unobserve(el); });
    }
    pageReveals = [];
  }

  /* ------------------------------------------------------------------- hero */

  function initHero(root) {
    var hero = root.querySelector('.knpo-hero');
    if (!hero) return;

    var media = hero.querySelector('.knpo-hero-media');
    var sheen = hero.querySelector('.knpo-hero-media-inner');
    var type = hero.querySelector('h1');

    pageMM.add('(min-width: 1024px) and (prefers-reduced-motion: no-preference)', function () {
      var tweens = [];

      if (type) {
        tweens.push(gsap.to(type, {
          y: -48,
          opacity: 0.45,
          ease: 'none',
          scrollTrigger: {
            trigger: hero,
            start: 'top top+=56',
            end: 'bottom top',
            scrub: 0.6
          }
        }));
      }

      if (media && sheen) {
        var tl = gsap.timeline({
          scrollTrigger: {
            trigger: media,
            start: 'top top+=72',
            end: '+=40%',
            pin: media,
            pinSpacing: true,
            scrub: 0.6,
            anticipatePin: 1,
            invalidateOnRefresh: true
          }
        });
        tl.fromTo(media,
          { scale: 1.03, borderRadius: '2.5rem' },
          { scale: 1, borderRadius: '2rem', ease: 'none' },
          0
        );
        tl.fromTo(sheen,
          { yPercent: -5, scale: 1.06 },
          { yPercent: 5, scale: 1.12, ease: 'none' },
          0
        );
        tweens.push(tl);
      }

      return function () {
        tweens.forEach(function (tween) {
          if (tween.scrollTrigger) tween.scrollTrigger.kill();
          tween.kill();
        });
      };
    });

    pageMM.add('(max-width: 1023px) and (prefers-reduced-motion: no-preference)', function () {
      if (!media || !sheen) return;
      var tween = gsap.fromTo(sheen,
        { yPercent: -3 },
        {
          yPercent: 5,
          ease: 'none',
          scrollTrigger: { trigger: media, start: 'top bottom', end: 'bottom top', scrub: true }
        }
      );
      return function () {
        if (tween.scrollTrigger) tween.scrollTrigger.kill();
        tween.kill();
      };
    });
  }

  /* --------------------------------------------------------------- splittext */

  function initSplit(root) {
    var targets = root.querySelectorAll('[data-split], h2.nest-display-sm, h2.nest-display-md');
    targets.forEach(function (el) {
      if (el.closest('.knpo-jam')) return;
      if (el.querySelector('a, button, input, select, textarea')) return;
      if (el.classList.contains('knpo-split-done')) return;

      el.setAttribute('data-split', '');

      if (!hasSplit || reduce.matches) {
        el.classList.add('knpo-split-done');
        return;
      }

      try {
        var split = SplitText.create(el, {
          type: 'lines',
          mask: 'lines',
          linesClass: 'knpo-split-line',
          autoSplit: true,
          deepSlice: false,
          aria: 'auto',
          onSplit: function (self) {
            if (!self.lines.length) return;
            return gsap.from(self.lines, {
              yPercent: 110,
              duration: 1,
              stagger: 0.08,
              ease: 'power4.out',
              scrollTrigger: { trigger: el, start: 'top 88%', once: true }
            });
          }
        });
        splits.push(split);
        el.classList.add('knpo-split-done');
      } catch (error) {
        el.classList.add('knpo-split-done');
      }
    });
  }

  /* ------------------------------------------------------------- color scrub */

  function initScrub(root) {
    if (!hasSplit || reduce.matches) return;

    root.querySelectorAll('[data-scrub]').forEach(function (el) {
      var end = getComputedStyle(el).color;
      var start = getComputedStyle(el).getPropertyValue('--knpo-scrub-start').trim();
      if (!start) start = 'rgba(242, 240, 248, 0.28)';
      var key = el.querySelector('.knpo-scrub-key');
      var accent = key ? getComputedStyle(key).color : end;

      try {
        var split = SplitText.create(el, {
          type: 'words',
          autoSplit: true,
          deepSlice: false,
          aria: 'auto',
          onSplit: function (self) {
            if (!self.words.length) return;

            var timeline = gsap.timeline({
              scrollTrigger: {
                trigger: el,
                start: 'top 80%',
                end: 'top 35%',
                scrub: 0.3
              }
            });

            self.words.forEach(function (word, i) {
              timeline.fromTo(word,
                { color: start },
                {
                  color: word.closest('.knpo-scrub-key') ? accent : end,
                  duration: 0.4,
                  ease: 'none'
                },
                i * 0.12
              );
            });

            return timeline;
          }
        });
        splits.push(split);
      } catch (error) {}
    });
  }

  /* ------------------------------------------------------------------ spine */

  function initSpine(root) {
    if (reduce.matches) return;

    var spine = root.querySelector('.knpo-spine');
    if (!spine) return;

    spine.querySelectorAll('.knpo-spine-item').forEach(function (item) {
      var copy = item.querySelector('.knpo-spine-copy');
      var fill = item.querySelector('.knpo-spine-fill');
      var reveal = null;

      if (copy) {
        reveal = gsap.fromTo(copy,
          { opacity: 0, y: 14 },
          { opacity: 1, y: 0, duration: 0.5, ease: 'power2.out', paused: true }
        );
      }

      ScrollTrigger.create({
        trigger: item,
        start: 'top 62%',
        toggleClass: { targets: item, className: 'is-active' },
        onEnter: function () {
          if (reveal) reveal.play();
        },
        onRefresh: function (self) {
          if (reveal && (self.progress > 0 || self.isActive)) reveal.progress(1);
        }
      });

      if (!fill) return;

      gsap.fromTo(fill,
        { scaleY: 0 },
        {
          scaleY: 1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 62%',
            end: 'bottom 62%',
            scrub: true,
            invalidateOnRefresh: true
          }
        }
      );
    });
  }

  /* ----------------------------------------------------------------- thumbs */

  function initThumbs(root) {
    if (reduce.matches) return;
    root.querySelectorAll('.knpo-work-thumb').forEach(function (thumb) {
      // y:0 keeps GSAP from baking the reveal's CSS translate into the inline transform.
      gsap.fromTo(thumb,
        { scale: 0.94, y: 0 },
        {
          scale: 1,
          y: 0,
          transformOrigin: '50% 100%',
          duration: 1.1,
          ease: 'power3.out',
          scrollTrigger: { trigger: thumb, start: 'top 88%', once: true }
        }
      );
    });
  }

  /* ----------------------------------------------------------------- ripples */

  function initRipples(scope) {
    if (!fine.matches || reduce.matches) return;
    (scope || document).querySelectorAll('.btn, [data-ripple]').forEach(function (el) {
      if (el.dataset.knpoRipple || el.matches('input, textarea, select')) return;
      el.dataset.knpoRipple = '1';

      var ripple = document.createElement('span');
      ripple.className = 'btn-ripple';
      ripple.setAttribute('aria-hidden', 'true');
      var dot = document.createElement('span');
      dot.className = 'btn-ripple-dot';
      ripple.appendChild(dot);
      el.prepend(ripple);

      function place(event) {
        var rect = el.getBoundingClientRect();
        dot.style.setProperty('--ripple-x', (event.clientX - rect.left) + 'px');
        dot.style.setProperty('--ripple-y', (event.clientY - rect.top) + 'px');
      }

      el.addEventListener('pointerenter', function (event) {
        place(event);
        el.classList.add('is-rippling');
      });
      el.addEventListener('pointermove', place);
      el.addEventListener('pointerleave', function () {
        el.classList.remove('is-rippling');
      });
    });
  }

  /* --------------------------------------------------------------- magnetics */

  function initMagnetics(scope) {
    if (!hasGsap || !fine.matches || reduce.matches) return;
    (scope || document).querySelectorAll('.btn-primary').forEach(function (el) {
      if (el.dataset.knpoMagnetic) return;
      el.dataset.knpoMagnetic = '1';

      var xTo = gsap.quickTo(el, 'x', { duration: 0.35, ease: 'power3.out' });
      var yTo = gsap.quickTo(el, 'y', { duration: 0.35, ease: 'power3.out' });
      var max = 10;

      function move(event) {
        var rect = el.getBoundingClientRect();
        var x = event.clientX - rect.left - rect.width / 2;
        var y = event.clientY - rect.top - rect.height / 2;
        xTo(Math.max(-max, Math.min(max, x * 0.18)));
        yTo(Math.max(-max, Math.min(max, y * 0.28)));
      }

      function leave() {
        xTo(0);
        yTo(0);
      }

      el.addEventListener('pointermove', move);
      el.addEventListener('pointerleave', leave);
    });
  }

  /* ------------------------------------------------------------------ barba */

  function initBarba() {
    if (!window.barba) return false;
    if (!document.querySelector('[data-barba="container"]') || !document.body.hasAttribute('data-barba')) return false;

    var overlay = document.querySelector('.knpo-transition');
    var panel = overlay ? overlay.querySelector('.knpo-transition-panel') : null;
    var mark = overlay ? overlay.querySelector('.knpo-transition-mark') : null;
    var announcer = document.querySelector('.knpo-announcer');
    var positions = Object.create(null);

    function pageKey(href) {
      var url = new URL(href, window.location.href);
      return url.pathname + url.search;
    }

    function saveScroll(data) {
      var url = data && data.current && data.current.url ? data.current.url.href : window.location.href;
      positions[pageKey(url)] = window.pageYOffset;
    }

    function scrollTo(y) {
      if (!lenis) {
        window.scrollTo(0, y);
        return;
      }
      // Lenis stop() sets overflow: clip on <html>, so briefly release it before scrolling.
      var stopped = lenis.isStopped;
      lenis.start();
      lenis.scrollTo(y, { immediate: true, force: true });
      if (stopped) lenis.stop();
    }

    function finish(timeline) {
      return new Promise(function (resolve) {
        timeline.eventCallback('onComplete', resolve);
      });
    }

    function cleanupOverlay() {
      if (!overlay) return;
      overlay.classList.remove('is-active');
      overlay.setAttribute('aria-hidden', 'true');
      if (hasGsap) {
        if (panel) gsap.set(panel, { clearProps: 'transform' });
        if (mark) gsap.set(mark, { clearProps: 'opacity,transform' });
      }
    }

    function overlayIn() {
      if (!overlay || !panel || !hasGsap || reduce.matches) return Promise.resolve();
      overlay.classList.add('is-active');
      gsap.set(panel, { yPercent: 101, y: 0 });
      if (mark) gsap.set(mark, { autoAlpha: 0, y: 16 });
      var timeline = gsap.timeline();
      timeline.to(panel, { yPercent: 0, duration: 0.55, ease: 'power4.inOut' }, 0);
      if (mark) timeline.to(mark, { autoAlpha: 1, y: 0, duration: 0.4, ease: 'power3.out' }, 0.15);
      return finish(timeline);
    }

    function overlayOut() {
      if (!overlay || !panel || !hasGsap || reduce.matches) {
        cleanupOverlay();
        return Promise.resolve();
      }
      var timeline = gsap.timeline();
      if (mark) timeline.to(mark, { autoAlpha: 0, y: -16, duration: 0.3, ease: 'power2.in' }, 0);
      timeline.to(panel, { yPercent: -101, duration: 0.55, ease: 'power4.inOut' }, 0.05);
      return finish(timeline).then(cleanupOverlay);
    }

    function updateNav(href) {
      if (!header) return;
      var path = new URL(href, window.location.href).pathname.replace(/\/+$/, '') || '/';
      header.querySelectorAll('nav a').forEach(function (link) {
        var linkPath = new URL(link.href, window.location.href).pathname.replace(/\/+$/, '') || '/';
        if (linkPath === path) {
          link.setAttribute('aria-current', 'page');
        } else {
          link.removeAttribute('aria-current');
        }
      });
    }

    function focusMain(container) {
      if (!container) return;
      if (!container.hasAttribute('tabindex')) container.setAttribute('tabindex', '-1');
      try { container.focus({ preventScroll: true }); } catch (error) { container.focus(); }
    }

    function announce() {
      if (!announcer) return;
      announcer.textContent = document.title;
    }

    function preventLink(data) {
      var el = data.el;
      var href = data.href;
      if (!el || !href) return false;
      if (el.closest('#wpadminbar') || el.closest('[data-barba-prevent]')) return true;
      if (el.hasAttribute('download')) return true;
      if (el.target && el.target !== '_self') return true;

      var url;
      try { url = new URL(href, window.location.href); } catch (error) { return true; }
      if (url.origin !== window.location.origin) return true;
      if (/\/(wp-admin|wp-login\.php|wp-json)(\/|$)/.test(url.pathname)) return true;
      if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) return true;
      return false;
    }

    window.addEventListener('pagehide', function () { saveScroll(); });

    function beforeEnter(data) {
      var initial = !data.current || !data.current.container;
      var historyNav = typeof data.trigger === 'string' && data.trigger !== 'barba';
      var y = historyNav ? (positions[pageKey(data.next.url.href)] || 0) : 0;
      // Barba removes the old container after `enter`; do it here so the overlay never reveals the old page.
      if (!initial) data.current.container.remove();
      docEl.classList.add('knpo-transitioning');

      initPage(data.next.container);
      refresh();
      if (!initial) scrollTo(y);
    }

    function afterEnter(data) {
      var initial = !data.current || !data.current.container;
      docEl.classList.remove('knpo-transitioning');
      if (lenis) lenis.start();
      refresh();
      updateNav(data.next.url.href);

      if (!initial) {
        focusMain(data.next.container);
        announce();
      }
    }

    barba.hooks.beforeEnter(beforeEnter);
    barba.hooks.afterEnter(afterEnter);

    try {
      barba.init({
        debug: false,
        timeout: 10000,
        preventRunning: true,
        cacheFirstPage: true,
        prevent: preventLink,
        transitions: [{
          name: 'knpo',
          beforeLeave: function (data) {
            saveScroll(data);
            if (lenis) lenis.stop();
            closeMenu();
            setHeaderHidden(false);
          },
          leave: function () {
            return overlayIn();
          },
          afterLeave: function () {
            destroyPage();
          },
          enter: function () {
            return overlayOut();
          }
        }]
      });
      return true;
    } catch (error) {
      if (window.console && console.error) console.error(error);
      return false;
    }
  }

  /* --------------------------------------------------------------- bootstrap */

  initMagnetics(document);
  initRipples(document);

  if (!initBarba()) {
    var container = document.querySelector('[data-barba="container"]');
    if (container) initPage(container);
  }

  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(refresh);
  }

  window.addEventListener('pageshow', function (event) {
    if (!event.persisted) return;
    if (lenis) lenis.start();
    setHeaderHidden(false);
    refresh();
  });

  // Last-resort visibility guard if a split target was never initialised.
  window.setTimeout(function () {
    markSplitDone(document.querySelector('[data-barba="container"]'));
  }, 3000);

})();
