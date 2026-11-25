// GREI site behaviour, matching Zenith's interactions:
// dropdowns, mobile menu, modals (Escape / backdrop to close), stay estimate, ridgeline footer.
import { mountRidgeline } from './ridgeline';
import { mountMotion } from './motion';
import { mountControls } from './controls';
import { mountCarousels } from './carousel';

// Styled selects and calendar date pickers
mountControls();
mountCarousels();

// Soft reveal-on-scroll animations (headings, blocks, photos)
window.__grMotion = true;
mountMotion();

// Dropdowns in the navbar: animated open/close, hover-to-open on desktop
const menus = [...document.querySelectorAll('[data-dropdown]')].map((wrap) => {
    const btn = wrap.querySelector('[data-dropdown-toggle]');
    const menu = wrap.querySelector('[data-dropdown-menu]');
    [...menu.querySelectorAll(':scope > a')].forEach((a, i) => a.style.setProperty('--i', String(i)));
    let timer;
    const show = () => {
        clearTimeout(timer);
        menus.forEach((m) => m !== api && m.hide());
        menu.hidden = false;
        requestAnimationFrame(() => requestAnimationFrame(() => menu.classList.add('is-open')));
        btn.setAttribute('aria-expanded', 'true');
    };
    const hide = () => {
        clearTimeout(timer);
        if (menu.hidden) return;
        menu.classList.remove('is-open');
        btn.setAttribute('aria-expanded', 'false');
        timer = setTimeout(() => { if (!menu.classList.contains('is-open')) menu.hidden = true; }, 420);
    };
    const api = { hide };
    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        btn.getAttribute('aria-expanded') === 'true' ? hide() : show();
    });
    if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        wrap.addEventListener('mouseenter', show);
        wrap.addEventListener('mouseleave', () => { clearTimeout(timer); timer = setTimeout(hide, 160); });
    }
    wrap.addEventListener('keydown', (e) => { if (e.key === 'Escape') { hide(); btn.focus(); } });
    return api;
});
document.addEventListener('mousedown', (e) => {
    if (!e.target.closest('[data-dropdown]')) menus.forEach((m) => m.hide());
});

// Mobile menu: morphing hamburger + staggered drawer
const mToggle = document.querySelector('[data-mobile-toggle]');
const mMenu = document.querySelector('[data-mobile-menu]');
if (mToggle && mMenu) {
    [...mMenu.children].forEach((c, i) => c.style.setProperty('--i', String(i)));
    let mTimer;
    mToggle.addEventListener('click', () => {
        clearTimeout(mTimer);
        const open = mToggle.getAttribute('aria-expanded') !== 'true';
        mToggle.setAttribute('aria-expanded', String(open));
        mToggle.setAttribute('aria-label', open ? 'Close navigation menu' : 'Open navigation menu');
        if (open) {
            mMenu.hidden = false;
            requestAnimationFrame(() => requestAnimationFrame(() => mMenu.classList.add('is-open')));
        } else {
            mMenu.classList.remove('is-open');
            mTimer = setTimeout(() => { mMenu.hidden = true; }, 560);
        }
    });
}

// Modals
const openModal = (id) => {
    const m = document.getElementById(id);
    if (!m) return;
    m.hidden = false;
    document.documentElement.classList.add('zr-modal-open');
    m.querySelector('input:not([type=hidden]), textarea, button')?.focus({ preventScroll: true });
};
const closeModal = (m) => {
    m.hidden = true;
    if (!document.querySelector('[data-modal]:not([hidden])')) document.documentElement.classList.remove('zr-modal-open');
};
// "Book a call", "Free consult" and "List a property" go to the full booking page
const BOOK = { 'modal-call': 'call', 'modal-consult': 'consult', 'modal-list': 'list' };
const bookUrl = (id) => `/book?for=${BOOK[id]}`;
document.querySelectorAll('[data-open-modal]').forEach((o) => {
    if (BOOK[o.dataset.openModal] && o.tagName === 'A') o.setAttribute('href', bookUrl(o.dataset.openModal));
});
document.addEventListener('click', (e) => {
    const opener = e.target.closest('[data-open-modal]');
    if (opener && BOOK[opener.dataset.openModal]) {
        if (opener.tagName === 'A' && (e.metaKey || e.ctrlKey)) return; // new tab via href
        e.preventDefault();
        window.location.href = bookUrl(opener.dataset.openModal);
        return;
    }
    if (opener) {
        if (e.metaKey || e.ctrlKey) return; // let cmd-click open the page
        e.preventDefault();
        document.querySelectorAll('[data-modal]:not([hidden])').forEach(closeModal);
        openModal(opener.dataset.openModal);
        return;
    }
    const closer = e.target.closest('[data-close-modal]');
    if (closer) closeModal(closer.closest('[data-modal]'));
    else if (e.target.matches('[data-modal]')) closeModal(e.target); // backdrop
});
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') document.querySelectorAll('[data-modal]:not([hidden])').forEach(closeModal);
});
document.querySelectorAll('[data-modal][data-autoshow]').forEach((m) => openModal(m.id));

// Stay request: live estimate (server recalculates)
document.querySelectorAll('[data-stay-quote]').forEach((form) => {
    const rate = Number(form.dataset.rate);
    const min = Number(form.dataset.minNights);
    const symbol = form.dataset.symbol;
    const inEl = form.querySelector('[name=check_in]');
    const outEl = form.querySelector('[name=check_out]');
    const out = form.querySelector('[data-quote-output]');
    const fmt = (n) => symbol + n.toLocaleString('en-US');
    const update = () => {
        if (inEl.value) outEl.min = inEl.value;
        const nights = Math.round((new Date(outEl.value) - new Date(inEl.value)) / 86400000);
        if (!inEl.value || !outEl.value || !(nights > 0)) {
            out.innerHTML = '<span class="text-[#8A8A8A]">Choose your dates to see an estimate.</span>';
            return;
        }
        const note = nights < min ? `<span class="block mt-1 text-red-700">Minimum stay is ${min} nights.</span>` : '';
        out.innerHTML = `<span class="flex justify-between"><span>${fmt(rate)} × ${nights} night${nights > 1 ? 's' : ''}</span><span class="font-medium text-[#111111]">${fmt(rate * nights)}</span></span>${note}`;
    };
    inEl.addEventListener('change', update);
    outEl.addEventListener('change', update);
    update();
});

// Image fallback: if a remote photo fails, use the local one
document.querySelectorAll('img[data-fallback]').forEach((img) => {
    const swap = () => { if (img.src !== img.dataset.fallback) { img.removeAttribute('srcset'); img.src = img.dataset.fallback; } };
    if (img.complete && img.naturalWidth === 0) swap();
    img.addEventListener('error', swap);
});

// Ridgeline dither footer
document.querySelectorAll('[data-ridgeline]').forEach((el) => mountRidgeline(el));

// Liquid-glass header: deepen the glass once the page has scrolled
const glass = document.querySelector('[data-glass-header]');
if (glass) {
    const onScroll = () => glass.classList.toggle('gr-scrolled', window.scrollY > 8);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

// "Find a stay" in the Stays hero: glide to whichever search panel is showing (photo on desktop, below it on mobile)
document.addEventListener('click', (e) => {
    const link = e.target.closest('a[href="#stay-search"]');
    if (!link) return;
    const panel = [...document.querySelectorAll('#stay-search .stays-search')].find((f) => f.offsetParent !== null);
    if (!panel) return;
    e.preventDefault();
    panel.scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth', block: 'center' });
    panel.classList.add('is-highlight');
    setTimeout(() => panel.classList.remove('is-highlight'), 1400);
    panel.querySelector('.zr-trigger')?.focus({ preventScroll: true });
});
