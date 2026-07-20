<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'لوحة التصميم') — سارا هوم</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-emblem.svg') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">

@php
    $hasVite = file_exists(public_path('hot')) || is_dir(public_path('build'));
@endphp

@if ($hasVite)
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    {{-- Fallback: renders the UI before `npm run build` is run --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { sans: ['Tajawal', 'sans-serif'], display: ['"Playfair Display"', 'serif'] },
                colors: {
                    canvas: '#F8F5F0', sand: '#EFE7DA', ink: '#2C3A5A', muted: '#8B8578', line: '#E5DCCB',
                    clay: { DEFAULT: '#B0854F', dark: '#93683A', soft: '#F3EADA' },
                    pine: { DEFAULT: '#4C7A63', soft: '#E1EDE6' },
                    ochre: { DEFAULT: '#C79B6D', soft: '#F5ECDD' },
                },
                boxShadow: { card: '0 12px 34px -20px rgba(44,58,90,.28)', soft: '0 18px 50px -24px rgba(44,58,90,.33)' },
            } }
        }
    </script>
    <style type="text/tailwindcss">
        @layer components {
            .btn { @apply inline-flex items-center justify-center gap-2 rounded-full px-5 py-3 text-sm font-bold transition; }
            .btn-primary { @apply btn bg-clay text-white hover:bg-clay-dark shadow-card; }
            .btn-ghost { @apply btn bg-white text-ink border border-line hover:border-clay/40 hover:text-clay; }
            .card { @apply rounded-2xl bg-white border border-line shadow-card; }
            .pill { @apply inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold; }
            .field { @apply w-full rounded-xl border-line bg-white placeholder:text-muted/70 focus:border-clay focus:ring-clay/30; }
            .nav-link { @apply relative flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium text-ink/60 transition-all duration-200 hover:bg-white hover:text-ink hover:shadow-card; }
            .nav-link.active { @apply bg-white font-bold text-clay shadow-card hover:text-clay; }
            .nav-link.active .nav-ind { @apply absolute inset-y-2 right-0 w-1 rounded-full bg-clay; }
            .nav-section { @apply px-3.5 pb-1.5 pt-5 text-[11px] font-bold tracking-[.18em] text-muted/70; }
        }
    </style>

    {{-- Interactivity for the no-build (CDN) mode: mirrors resources/js/app.js so
         the modal, loading states and image preview work without running npm. --}}
    <script>
        document.addEventListener('click', function (e) {
            var opener = e.target.closest('[data-modal-open]');
            if (opener) {
                var el = document.getElementById(opener.dataset.modalOpen);
                if (el) { el.classList.remove('hidden'); el.classList.add('flex'); }
            }
            var closer = e.target.closest('[data-modal-close]');
            if (closer) {
                var modal = closer.closest('[data-modal]');
                if (modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); }
            }
            if (e.target.closest('[data-sidebar-toggle]')) {
                var sb = document.querySelector('[data-sidebar]');
                if (sb) sb.classList.toggle('translate-x-full');
            }
        });

        document.addEventListener('submit', function (e) {
            var btn = e.target.querySelector('button[type="submit"], button:not([type])');
            if (!btn || btn.dataset.busy === '1') return;
            btn.dataset.busy = '1';
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-wait');
            var busyText = btn.dataset.busyText || 'جارٍ المعالجة…';
            btn.innerHTML =
                '<svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">' +
                '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>' +
                '<path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>' +
                '</svg><span>' + busyText + '</span>';
        });

        document.addEventListener('change', function (e) {
            var input = e.target.closest('input[type="file"][name="image"]');
            if (!input || !input.files || !input.files.length) return;
            var file = input.files[0];
            var label = input.closest('label');
            if (!label) return;
            var url = URL.createObjectURL(file);
            label.innerHTML =
                '<img src="' + url + '" alt="معاينة الصورة" class="h-28 w-full rounded-xl object-cover">' +
                '<span class="mt-2 text-xs font-bold text-clay">' + file.name + '</span>' +
                '<span class="text-[11px] text-muted">اضغطي لاختيار صورة أخرى</span>';
            label.appendChild(input);
        });

        document.querySelectorAll('[data-toast]').forEach(function (t) {
            setTimeout(function () { t.classList.add('opacity-0', 'translate-y-3'); }, 3200);
        });
    </script>
@endif

<style>
    body { font-family: 'Tajawal', sans-serif; }
    [data-sidebar] { transition: width .25s ease, transform .3s ease; }
    [data-sidebar].collapsed { width: 88px; }
    .font-display { font-family: 'Playfair Display', serif; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }
    .animate-fade-up { animation: fadeUp .5s ease both; }
    ::-webkit-scrollbar { width: 10px; height: 10px; }
    ::-webkit-scrollbar-thumb { background: #ddcdb9; border-radius: 9999px; border: 2px solid #f7f2ec; }
</style>
