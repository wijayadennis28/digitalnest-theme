(function () {
  'use strict';

  var fine = window.matchMedia('(hover: hover) and (pointer: fine)');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
  if (!fine.matches || reduce.matches) return;

  // motion.js calls this on every Barba page swap; the dataset flag keeps re-runs cheap.
  window.knpoInitJam = function (scope) {
    (scope || document).querySelectorAll('.knpo-jam').forEach(function (jam) {
      if (jam.dataset.knpoJam) return;
      var pixel = jam.querySelector('.knpo-jam-pixel');
      if (!pixel) return;
      jam.dataset.knpoJam = '1';

      // Signal CSS that the halo is available, so the plain colour hover becomes a fallback.
      jam.classList.add('knpo-jam-ready');

      var maxX = 7;
      var maxY = 5;
      var targetX = 0;
      var targetY = 0;
      var currentX = 0;
      var currentY = 0;
      var raf = null;

      function clamp(value, min, max) {
        return Math.max(min, Math.min(max, value));
      }

      function track(event) {
        var rect = jam.getBoundingClientRect();
        var x = event.clientX - rect.left;
        var y = event.clientY - rect.top;

        jam.style.setProperty('--jam-x', x + 'px');
        jam.style.setProperty('--jam-y', y + 'px');
        jam.classList.add('is-jam-active');

        // Pull toward the pointer, measured from the centre of the word.
        targetX = clamp((x - rect.width / 2) * 0.045, -maxX, maxX);
        targetY = clamp((y - rect.height / 2) * 0.06, -maxY, maxY);

        if (raf === null) raf = requestAnimationFrame(tick);
      }

      function tick() {
        currentX += (targetX - currentX) * 0.16;
        currentY += (targetY - currentY) * 0.16;

        var settled = Math.abs(targetX - currentX) < 0.04 && Math.abs(targetY - currentY) < 0.04;
        if (settled) {
          currentX = targetX;
          currentY = targetY;
        }

        jam.style.transform = 'translate3d(' + currentX.toFixed(2) + 'px,' + currentY.toFixed(2) + 'px,0)';

        if (settled) {
          raf = null;
          if (targetX === 0 && targetY === 0) jam.style.transform = '';
        } else {
          raf = requestAnimationFrame(tick);
        }
      }

      jam.addEventListener('pointerenter', track);
      jam.addEventListener('pointermove', track);

      jam.addEventListener('pointerleave', function () {
        jam.classList.remove('is-jam-active');
        targetX = 0;
        targetY = 0;
        if (raf === null) raf = requestAnimationFrame(tick);
      });

      // The element can scroll out from under a still pointer; close the bloom and ease the word home.
      window.addEventListener('scroll', function () {
        if (!jam.classList.contains('is-jam-active')) return;
        jam.classList.remove('is-jam-active');
        targetX = 0;
        targetY = 0;
        if (raf === null) raf = requestAnimationFrame(tick);
      }, { passive: true });
    });
  };

  window.knpoInitJam(document);
})();
