// Soft reveal-on-scroll for the whole site, in the spirit of the ridgeline footer:
// headings resolve word by word from a stepped blur, blocks slide up and sharpen,
// big photos settle from a slight zoom. Everything runs once per element.

const SKIP = '[data-modal], nav, header, footer, [data-ridgeline], [data-carousel]';

const usable = (el) => !el.closest(SKIP) && !el.closest('.gr-reveal, .gr-settle, .gr-words');

// Wrap each word of a heading in a span, keeping <br> and inline elements intact.
function splitWords(heading) {
    let i = 0;
    const walk = (node) => {
        [...node.childNodes].forEach((child) => {
            if (child.nodeType === Node.TEXT_NODE) {
                const parts = child.textContent.split(/(\s+)/);
                if (!child.textContent.trim()) return;
                const frag = document.createDocumentFragment();
                parts.forEach((part) => {
                    if (!part) return;
                    if (/^\s+$/.test(part)) { frag.append(document.createTextNode(part)); return; }
                    const w = document.createElement('span');
                    w.className = 'gr-w';
                    w.style.setProperty('--d', String(i++ * 70));
                    w.textContent = part;
                    frag.append(w);
                });
                child.replaceWith(frag);
            } else if (child.nodeType === Node.ELEMENT_NODE && child.tagName !== 'BR') {
                if (child.matches('i, svg, img')) {
                    child.classList.add('gr-w');
                    child.style.setProperty('--d', String(i++ * 70));
                } else {
                    walk(child);
                }
            }
        });
    };
    walk(heading);
    heading.classList.add('gr-words');
}

export function mountMotion(root = document.querySelector('main')) {
    if (!root) return;
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const targets = [];

    // 1. Headings
    root.querySelectorAll('h1, h2').forEach((h) => {
        if (h.closest(SKIP)) return;
        splitWords(h);
        targets.push(h);
    });

    // 2. Large photos (hero and feature images): the image's own wrapper settles.
    root.querySelectorAll('img').forEach((img) => {
        const box = img.parentElement;
        if (!usable(box) || img.closest('a') || !img.classList.contains('w-full')) return;
        box.classList.add('gr-settle');
        targets.push(box);
    });

    // 3. Grid items (cards, feature panels), staggered across each row.
    root.querySelectorAll('[class*="grid-cols"]').forEach((grid) => {
        const cols = Math.max(1, getComputedStyle(grid).gridTemplateColumns.split(' ').length);
        [...grid.children].forEach((item, n) => {
            if (!usable(item) || item.classList.contains('gr-settle')) return;
            if (item.querySelector('.gr-settle')) return; // feature image column handled above
            item.classList.add('gr-reveal');
            item.style.setProperty('--d', String((n % cols) * 110));
            targets.push(item);
        });
    });

    // 4. Loose text and buttons that are not already inside a revealed block.
    root.querySelectorAll('[data-reveal], p, form, .zr-btn-hero, .zr-btn-dark, .zr-btn-outline, .zr-chip, h3, dl, ul').forEach((el) => {
        if (!usable(el)) return;
        el.classList.add('gr-reveal');
        el.style.setProperty('--d', el.matches('[class*="zr-btn"]') ? '240' : '120');
        targets.push(el);
    });

    if (reduce || !('IntersectionObserver' in window)) {
        targets.forEach((t) => t.classList.add('gr-in'));
        return;
    }

    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (!e.isIntersecting) return;
            e.target.classList.add('gr-in');
            io.unobserve(e.target);
        });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });
    targets.forEach((t) => io.observe(t));
}
