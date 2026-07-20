@extends('layouts.app')
@section('title', 'متجر الأثاث')
@section('heading', 'متجر الأثاث')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold tracking-[.2em] text-clay">تسوّقي حسب القسم</p>
            <h1 class="mt-1 font-display text-3xl">متجر الأثاث</h1>
            <p class="mt-1 text-muted">{{ $productCount }} منتجاً موزّعة على {{ $categories->count() }} أقسام رئيسية — اختاري القسم لتصفّح القطع.</p>
        </div>
        <form method="GET" action="{{ route('client.store') }}" class="relative w-full sm:w-80">
            <input name="q" value="{{ $q }}" type="search" placeholder="ابحثي عن قطعة… كنبة، سرير، قماش"
                   class="field !rounded-full !py-3 pl-11"
                   aria-label="بحث في المتجر">
            <button class="absolute left-1.5 top-1/2 grid h-9 w-9 -translate-y-1/2 place-items-center rounded-full bg-clay text-white transition hover:bg-clay-dark" aria-label="بحث">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
                </svg>
            </button>
        </form>
    </div>

    @if ($results !== null)
        <div class="mt-6 flex items-center justify-between">
            <h2 class="font-display text-2xl">نتائج البحث عن «{{ $q }}»</h2>
            <a href="{{ route('client.store') }}" class="pill border border-line bg-white hover:border-clay/40">× مسح البحث</a>
        </div>

        @if ($results->isEmpty())
            <div class="card mt-4 flex flex-col items-center gap-3 p-10 text-center">
                <h3 class="font-display text-xl">ما لقينا نتائج</h3>
                <p class="max-w-sm text-sm text-muted">جرّبي كلمة أخرى — مثلاً: كنبة، سرير، ستارة، خشب، قماش.</p>
            </div>
        @else
            <div class="mt-4 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($results as $product)
                    <a href="{{ route('client.store.show', $product) }}"
                       class="card group overflow-hidden transition hover:-translate-y-1 hover:shadow-soft">
                        <div class="relative aspect-[4/3] overflow-hidden bg-sand">
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            @if ($product->category)
                                <span class="absolute right-3 top-3 pill bg-white/90 text-ink">{{ $product->category->name }}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="font-display text-lg">{{ $product->name }}</h3>
                                <span class="whitespace-nowrap font-bold text-clay">{{ $product->priceLabel() }}</span>
                            </div>
                            <p class="mt-1 line-clamp-2 text-sm text-muted">{{ $product->description }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    @endif

    @if ($results === null && $featured)
        <a href="{{ route('client.store.show', $featured) }}"
           class="mt-6 grid overflow-hidden rounded-3xl border border-line bg-white shadow-card sm:grid-cols-[1.1fr,.9fr]">
            <div class="flex flex-col justify-center p-7 sm:p-9">
                <span class="pill w-fit bg-clay-soft text-clay">قطعة الأسبوع</span>
                <h2 class="mt-3 font-display text-3xl">{{ $featured->name }}</h2>
                <p class="mt-2 max-w-md text-muted">{{ $featured->description }}</p>
                <p class="mt-4 text-2xl font-bold text-clay">{{ $featured->priceLabel() }}</p>
                <span class="btn-primary mt-5 w-fit">عرض التفاصيل ←</span>
            </div>
            <div class="min-h-[240px] bg-sand">
                <img src="{{ $featured->imageUrl() }}" alt="{{ $featured->name }}" class="h-full w-full object-cover">
            </div>
        </a>
    @endif

    @if ($results === null)
    <h2 class="mt-8 font-display text-2xl">الأقسام</h2>
    <div class="mt-4 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($categories as $category)
            <a href="{{ route('client.store.category', $category) }}"
               class="card group overflow-hidden transition hover:-translate-y-1 hover:shadow-soft">
                <div class="relative aspect-[16/10] overflow-hidden bg-sand">
                    <img src="{{ asset('images/'.$category->image_path) }}" alt="{{ $category->name }}"
                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    <span class="absolute right-3 top-3 pill bg-white/90 text-ink">{{ $category->totalProductsCount() }} منتج</span>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="font-display text-xl">{{ $category->name }}</h3>
                        <span class="text-clay">←</span>
                    </div>
                    <p class="mt-1 text-sm text-muted">{{ $category->description }}</p>
                    @if ($category->children->isNotEmpty())
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            @foreach ($category->children as $child)
                                <span class="pill bg-sand text-ink">{{ $child->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
    @endif
@endsection
