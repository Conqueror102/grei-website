// Custom form controls in the Zenith style, built on top of the native fields so
// forms still submit exactly as before:
//  - every <select class="zr-input"> becomes a styled button + animated glass list
//  - every <input type="date" class="zr-input"> becomes a button + calendar popover
//    (check-in / check-out pairs share one range highlight)
// Popovers are attached to <body> so modals and overflow never clip them.

const MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
const DAYS = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];

let current = null; // { pop, close }

const pad = (n) => String(n).padStart(2, '0');
const iso = (d) => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
const parse = (s) => {
    if (!s) return null;
    const [y, m, d] = s.split('-').map(Number);
    return y ? new Date(y, m - 1, d) : null;
};
const pretty = (d) => d.toLocaleDateString('en-GB', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });

function el(tag, cls, html) {
    const n = document.createElement(tag);
    if (cls) n.className = cls;
    if (html != null) n.innerHTML = html;
    return n;
}

// ---- Popover plumbing ----------------------------------------------------
function place(pop, anchor) {
    const r = anchor.getBoundingClientRect();
    const w = Math.max(r.width, pop.dataset.minw ? Number(pop.dataset.minw) : 0);
    pop.style.width = `${w}px`;
    let left = Math.min(r.left, window.innerWidth - w - 12);
    left = Math.max(12, left);
    const below = window.innerHeight - r.bottom;
    const h = pop.offsetHeight;
    const up = below < h + 16 && r.top > h + 16;
    pop.style.left = `${left}px`;
    pop.style.top = `${up ? r.top - h - 8 : r.bottom + 8}px`;
    pop.style.transformOrigin = up ? '50% 100%' : '50% 0';
}

function openPop(pop, anchor, onClose) {
    if (current) current.close();
    document.body.append(pop);
    pop.hidden = false;
    place(pop, anchor);
    requestAnimationFrame(() => pop.classList.add('is-open'));
    anchor.setAttribute('aria-expanded', 'true');
    anchor.classList.add('is-active');

    const reposition = () => place(pop, anchor);
    const outside = (e) => { if (!pop.contains(e.target) && !anchor.contains(e.target)) close(); };
    const close = () => {
        if (!current || current.pop !== pop) return;
        current = null;
        pop.classList.remove('is-open');
        anchor.setAttribute('aria-expanded', 'false');
        anchor.classList.remove('is-active');
        window.removeEventListener('resize', reposition);
        window.removeEventListener('scroll', reposition, true);
        document.removeEventListener('pointerdown', outside, true);
        setTimeout(() => { if (!pop.classList.contains('is-open')) { pop.hidden = true; pop.remove(); } }, 220);
        onClose?.();
    };
    window.addEventListener('resize', reposition);
    window.addEventListener('scroll', reposition, true);
    document.addEventListener('pointerdown', outside, true);
    current = { pop, close };
    return close;
}

// ---- Select --------------------------------------------------------------
function enhanceSelect(select) {
    const wrap = el('div', 'zr-field');
    select.parentNode.insertBefore(wrap, select);
    const btn = el('button', 'zr-input zr-trigger');
    btn.type = 'button';
    btn.setAttribute('aria-haspopup', 'listbox');
    btn.setAttribute('aria-expanded', 'false');
    const label = el('span', 'zr-trigger-text');
    btn.append(label, el('i', 'ph-duotone ph-caret-down zr-caret'));
    wrap.append(btn, select);
    select.classList.add('zr-native');
    select.tabIndex = -1;
    select.setAttribute('aria-hidden', 'true');

    const sync = () => { label.textContent = select.options[select.selectedIndex]?.text ?? ''; };
    sync();
    select.addEventListener('change', sync);

    let close = null;
    const choose = (i) => {
        if (select.selectedIndex !== i) {
            select.selectedIndex = i;
            select.dispatchEvent(new Event('change', { bubbles: true }));
        }
        close?.();
        btn.focus({ preventScroll: true });
    };

    const open = () => {
        const pop = el('div', 'zr-pop zr-list');
        pop.setAttribute('role', 'listbox');
        [...select.options].forEach((o, i) => {
            const item = el('button', 'zr-option', `<span>${o.text}</span><i class="ph-duotone ph-check"></i>`);
            item.type = 'button';
            item.setAttribute('role', 'option');
            item.setAttribute('aria-selected', String(i === select.selectedIndex));
            item.style.setProperty('--i', String(i));
            item.addEventListener('click', () => choose(i));
            item.addEventListener('keydown', (e) => {
                const items = [...pop.querySelectorAll('.zr-option')];
                const k = items.indexOf(item);
                if (e.key === 'ArrowDown') { e.preventDefault(); items[Math.min(k + 1, items.length - 1)].focus(); }
                if (e.key === 'ArrowUp') { e.preventDefault(); items[Math.max(k - 1, 0)].focus(); }
                if (e.key === 'Escape') { e.preventDefault(); e.stopPropagation(); close(); btn.focus(); }
                if (e.key === 'Tab') close();
            });
            pop.append(item);
        });
        close = openPop(pop, btn);
        pop.querySelectorAll('.zr-option')[Math.max(0, select.selectedIndex)]?.focus({ preventScroll: true });
    };

    btn.addEventListener('click', () => (btn.getAttribute('aria-expanded') === 'true' ? close?.() : open()));
    btn.addEventListener('keydown', (e) => {
        if (['ArrowDown', 'ArrowUp'].includes(e.key)) { e.preventDefault(); open(); }
    });
}

// ---- Date picker -----------------------------------------------------------
const pairs = new Map(); // form -> { in, out }

function enhanceDate(input) {
    const form = input.form;
    const wrap = el('div', 'zr-field');
    input.parentNode.insertBefore(wrap, input);
    const btn = el('button', 'zr-input zr-trigger');
    btn.type = 'button';
    btn.setAttribute('aria-haspopup', 'dialog');
    btn.setAttribute('aria-expanded', 'false');
    const label = el('span', 'zr-trigger-text');
    btn.append(el('i', 'ph-duotone ph-calendar-blank zr-cal-icon'), label);
    input.type = 'hidden';
    wrap.append(btn, input);

    const role = input.name === 'check_in' ? 'in' : input.name === 'check_out' ? 'out' : null;
    if (form && role) {
        const p = pairs.get(form) ?? {};
        p[role] = { input, btn, open: null };
        pairs.set(form, p);
    }
    const partner = () => (form && role ? pairs.get(form)?.[role === 'in' ? 'out' : 'in'] : null);

    const sync = () => {
        const d = parse(input.value);
        label.textContent = d ? pretty(d) : (role === 'out' ? 'Add check-out' : role === 'in' ? 'Add check-in' : 'Choose a date');
        btn.classList.toggle('is-empty', !d);
    };
    sync();
    input.addEventListener('change', sync);

    let view = parse(input.value) ?? parse(input.min) ?? new Date();
    view = new Date(view.getFullYear(), view.getMonth(), 1);
    let close = null;

    const set = (d) => {
        input.value = iso(d);
        input.dispatchEvent(new Event('change', { bubbles: true }));
        const other = partner();
        if (role === 'in' && other) {
            const next = new Date(d); next.setDate(next.getDate() + 1);
            other.input.min = iso(next);
            const out = parse(other.input.value);
            if (out && out <= d) { other.input.value = ''; other.input.dispatchEvent(new Event('change', { bubbles: true })); }
            close?.();
            if (!parse(other.input.value)) setTimeout(() => other.open?.(), 230);
            return;
        }
        close?.();
        btn.focus({ preventScroll: true });
    };

    const render = (pop, dir = 0) => {
        const min = parse(input.min);
        const sel = parse(input.value);
        const other = partner();
        const a = role === 'in' ? sel : parse(other?.input.value);
        const b = role === 'out' ? sel : parse(other?.input.value);
        const today = new Date(); today.setHours(0, 0, 0, 0);

        const grid = el('div', 'zr-cal-grid');
        if (dir) grid.classList.add(dir > 0 ? 'from-right' : 'from-left');
        DAYS.forEach((d) => grid.append(el('span', 'zr-cal-dow', d)));
        const first = (view.getDay() + 6) % 7;
        for (let i = 0; i < first; i++) grid.append(el('span'));
        const days = new Date(view.getFullYear(), view.getMonth() + 1, 0).getDate();
        for (let n = 1; n <= days; n++) {
            const d = new Date(view.getFullYear(), view.getMonth(), n);
            const cell = el('button', 'zr-day', String(n));
            cell.type = 'button';
            cell.style.setProperty('--i', String(first + n));
            cell.setAttribute('aria-label', pretty(d));
            if (min && d < min) cell.disabled = true;
            if (+d === +today) cell.classList.add('is-today');
            if (a && +d === +a) cell.classList.add('is-start');
            if (b && +d === +b) cell.classList.add('is-end');
            if (a && b && d > a && d < b) cell.classList.add('in-range');
            if (sel && +d === +sel) cell.classList.add('is-selected');
            cell.addEventListener('click', () => set(d));
            grid.append(cell);
        }
        const title = pop.querySelector('.zr-cal-title');
        title.textContent = `${MONTHS[view.getMonth()]} ${view.getFullYear()}`;
        pop.querySelector('.zr-cal-grid')?.remove();
        pop.querySelector('.zr-cal-body').append(grid);
        const prev = pop.querySelector('[data-prev]');
        prev.disabled = !!min && new Date(view.getFullYear(), view.getMonth(), 0) < min;
    };

    const open = () => {
        const pop = el('div', 'zr-pop zr-cal');
        pop.dataset.minw = '300';
        pop.setAttribute('role', 'dialog');
        pop.setAttribute('aria-label', 'Choose a date');
        pop.innerHTML = `
            <div class="zr-cal-head">
                <button type="button" class="zr-cal-nav" data-prev aria-label="Previous month"><i class="ph-duotone ph-caret-left"></i></button>
                <span class="zr-cal-title"></span>
                <button type="button" class="zr-cal-nav" data-next aria-label="Next month"><i class="ph-duotone ph-caret-right"></i></button>
            </div>
            <div class="zr-cal-body"></div>
            <div class="zr-cal-foot">
                <span>${role === 'in' ? 'Check-in' : role === 'out' ? 'Check-out' : 'Select a day'}</span>
                <button type="button" data-clear>Clear</button>
            </div>`;
        const sel = parse(input.value) ?? parse(input.min);
        if (sel) view = new Date(sel.getFullYear(), sel.getMonth(), 1);
        render(pop);
        pop.querySelector('[data-prev]').addEventListener('click', () => { view.setMonth(view.getMonth() - 1); render(pop, -1); });
        pop.querySelector('[data-next]').addEventListener('click', () => { view.setMonth(view.getMonth() + 1); render(pop, 1); });
        pop.querySelector('[data-clear]').addEventListener('click', () => {
            input.value = '';
            input.dispatchEvent(new Event('change', { bubbles: true }));
            close?.();
        });
        pop.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') { e.preventDefault(); e.stopPropagation(); close?.(); btn.focus(); }
        });
        close = openPop(pop, btn);
        (pop.querySelector('.zr-day.is-selected') ?? pop.querySelector('.zr-day:not(:disabled)'))?.focus({ preventScroll: true });
    };
    if (form && role) pairs.get(form)[role].open = open;

    btn.addEventListener('click', () => (btn.getAttribute('aria-expanded') === 'true' ? close?.() : open()));
}

export function mountControls(root = document) {
    root.querySelectorAll('select.zr-input:not(.zr-native)').forEach(enhanceSelect);
    root.querySelectorAll('input[type="date"].zr-input').forEach(enhanceDate);
}
