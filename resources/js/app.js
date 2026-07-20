import './bootstrap';

document.addEventListener('click', (e) => {
    const opener = e.target.closest('[data-modal-open]');
    if (opener) {
        const el = document.getElementById(opener.dataset.modalOpen);
        el?.classList.remove('hidden');
        el?.classList.add('flex');
    }
    const closer = e.target.closest('[data-modal-close]');
    if (closer) {
        const modal = closer.closest('[data-modal]');
        modal?.classList.add('hidden');
        modal?.classList.remove('flex');
    }
    if (e.target.closest('[data-sidebar-toggle]')) {
        document.querySelector('[data-sidebar]')?.classList.toggle('translate-x-full');
    }
});

document.querySelectorAll('[data-toast]').forEach((t) => {
    setTimeout(() => t.classList.add('opacity-0', 'translate-y-3'), 3200);
});

/* ----- Loading state on submit (so a slow AI call never looks frozen) ----- */
document.addEventListener('submit', (e) => {
    const btn = e.target.querySelector('button[type="submit"], button:not([type])');
    if (!btn || btn.dataset.busy === '1') return;

    btn.dataset.busy = '1';
    btn.disabled = true;
    btn.classList.add('opacity-70', 'cursor-wait');

    const busyText = btn.dataset.busyText || 'جارٍ المعالجة…';
    btn.innerHTML =
        '<svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">' +
        '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>' +
        '<path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>' +
        '</svg><span>' + busyText + '</span>';
});

/* ----- Room photo preview inside the new-project modal ----- */
document.addEventListener('change', (e) => {
    const input = e.target.closest('input[type="file"][name="image"]');
    if (!input || !input.files || !input.files.length) return;

    const file = input.files[0];
    const label = input.closest('label');
    if (!label) return;

    const url = URL.createObjectURL(file);
    label.innerHTML =
        '<img src="' + url + '" alt="معاينة الصورة" class="h-28 w-full rounded-xl object-cover">' +
        '<span class="mt-2 text-xs font-bold text-clay">' + file.name + '</span>' +
        '<span class="text-[11px] text-muted">اضغطي لاختيار صورة أخرى</span>';
    label.appendChild(input); // keep the input in the DOM so the file still submits
});
