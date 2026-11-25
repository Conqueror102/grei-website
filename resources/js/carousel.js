// Home hero carousel: crossfade slides, autoplay with progress, pause on hover/focus,
// arrows, dots, keyboard and swipe. No autoplay for people who prefer reduced motion.
export function mountCarousels() {
    document.querySelectorAll('[data-carousel]').forEach((root) => {
        const slides = [...root.querySelectorAll('[data-slide]')];
        const dots = [...root.querySelectorAll('[data-dot]')];
        if (slides.length < 2) return;
        const interval = Number(root.dataset.interval) || 6500;
        const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let index = 0;
        let timer = null;
        let paused = false;

        const restart = () => {
            clearTimeout(timer);
            root.style.setProperty('--hc-dur', `${interval}ms`);
            root.classList.remove('is-ticking');
            void root.offsetWidth; // restart the progress bar
            if (reduce || paused) return;
            root.classList.add('is-ticking');
            timer = setTimeout(() => go(index + 1), interval);
        };
        const go = (n) => {
            index = (n + slides.length) % slides.length;
            slides.forEach((s, i) => {
                const on = i === index;
                s.classList.toggle('is-active', on);
                s.setAttribute('aria-hidden', on ? 'false' : 'true');
                s.querySelectorAll('a').forEach((a) => (on ? a.removeAttribute('tabindex') : a.setAttribute('tabindex', '-1')));
                if (on) s.querySelectorAll('img[loading="lazy"]').forEach((img) => { img.loading = 'eager'; });
            });
            dots.forEach((d, i) => d.setAttribute('aria-selected', String(i === index)));
            restart();
        };
        const pause = () => { paused = true; clearTimeout(timer); root.classList.add('is-paused'); };
        const resume = () => { paused = false; root.classList.remove('is-paused'); restart(); };

        root.querySelector('[data-prev]')?.addEventListener('click', () => go(index - 1));
        root.querySelector('[data-next]')?.addEventListener('click', () => go(index + 1));
        dots.forEach((d) => d.addEventListener('click', () => go(Number(d.dataset.dot))));
        root.addEventListener('mouseenter', pause);
        root.addEventListener('mouseleave', resume);
        root.addEventListener('focusin', pause);
        root.addEventListener('focusout', (e) => { if (!root.contains(e.relatedTarget)) resume(); });
        root.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') go(index + 1);
            if (e.key === 'ArrowLeft') go(index - 1);
        });
        let x0 = null;
        root.addEventListener('touchstart', (e) => { x0 = e.touches[0].clientX; }, { passive: true });
        root.addEventListener('touchend', (e) => {
            if (x0 === null) return;
            const dx = e.changedTouches[0].clientX - x0;
            if (Math.abs(dx) > 40) go(index + (dx < 0 ? 1 : -1));
            x0 = null;
        });
        document.addEventListener('visibilitychange', () => (document.hidden ? clearTimeout(timer) : restart()));
        // Warm the next slides' photos once the page has settled
        window.addEventListener('load', () => slides.forEach((s) => s.querySelectorAll('img[loading="lazy"]').forEach((img) => { img.loading = 'eager'; })));
        restart();
    });
}
