@extends('layouts.app')
@section('title', 'معرض الإلهام')
@section('heading', 'معرض الإلهام')

@section('content')
    <div>
        <p class="text-xs font-bold tracking-[.2em] text-clay">أفكار مصمّمة لك</p>
        <h1 class="mt-1 font-display text-3xl">معرض الإلهام</h1>
        <p class="mt-1 text-muted">اختاري ما يشبهك واحفظي أفكارك لمشروعك القادم.</p>
    </div>

    <div class="mt-5 flex flex-wrap gap-2" data-filters>
        <button data-filter="all" class="pill bg-ink text-white">الكل</button>
        @foreach ($tags as $tag)
            <button data-filter="{{ $tag }}" class="pill border border-line bg-white text-ink hover:border-clay/40">{{ $tag }}</button>
        @endforeach
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($inspirations as $insp)
            <article data-tag="{{ $insp->tag }}" class="card group overflow-hidden">
                <div class="relative h-52 overflow-hidden" style="background:{{ $insp->accent_color }};">
                    @if ($insp->image_path)
                        <img src="{{ asset('images/'.$insp->image_path) }}" alt="{{ $insp->title }}"
                             class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    @endif
                    <div class="absolute inset-0" style="background:linear-gradient(160deg, rgba(255,255,255,.05), rgba(43,38,34,.45));"></div>
                    <button data-fav data-type="inspiration" data-id="{{ $insp->id }}" aria-label="حفظ الفكرة"
                            class="absolute left-3 top-3 grid h-9 w-9 place-items-center rounded-full bg-white/85 text-clay transition hover:bg-white">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="{{ in_array($insp->id, $favoriteIds) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 20s-7-4.3-9.3-8.3C1.2 8.9 2.6 5.5 6 5.5c2 0 3.2 1.2 4 2.3.8-1.1 2-2.3 4-2.3 3.4 0 4.8 3.4 3.3 6.2C19 15.7 12 20 12 20z"/>
                        </svg>
                    </button>
                    <div class="absolute inset-x-0 bottom-0 p-4 text-white">
                        <span class="pill bg-white/20 text-white backdrop-blur">{{ $insp->style }}</span>
                        <h3 class="mt-2 font-display text-xl drop-shadow">{{ $insp->title }}</h3>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endsection

@push('scripts')
<script>
    const filterBtns = document.querySelectorAll('[data-filter]');
    const cards = document.querySelectorAll('[data-tag]');
    filterBtns.forEach((btn) => btn.addEventListener('click', () => {
        filterBtns.forEach((b) => b.classList.remove('bg-ink', 'text-white'));
        filterBtns.forEach((b) => b.classList.add('bg-white', 'text-ink', 'border', 'border-line'));
        btn.classList.add('bg-ink', 'text-white');
        btn.classList.remove('bg-white', 'text-ink');
        const f = btn.dataset.filter;
        cards.forEach((c) => c.style.display = (f === 'all' || c.dataset.tag === f) ? '' : 'none');
    }));
    document.querySelectorAll('[data-fav]').forEach((b) => b.addEventListener('click', async () => {
        const svg = b.querySelector('svg');
        try {
            const res = await fetch('{{ route('client.favorites.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
                body: JSON.stringify({ type: b.dataset.type, id: b.dataset.id }),
            });
            const data = await res.json();
            svg.setAttribute('fill', data.on ? 'currentColor' : 'none');
        } catch (e) { /* keep silent; heart just won't toggle */ }
    }));
</script>
@endpush
