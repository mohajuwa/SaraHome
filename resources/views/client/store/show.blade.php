@extends('layouts.app')
@section('title', $product->name)
@section('heading', 'تفاصيل المنتج')

@section('content')
    <div class="flex flex-wrap items-center gap-2 text-sm text-muted">
        <a href="{{ route('client.store') }}" class="hover:text-clay">المتجر</a>
        @if ($product->category)
            <span>/</span>
            <a href="{{ route('client.store.category', $product->category) }}" class="hover:text-clay">{{ $product->category->name }}</a>
        @endif
    </div>

    <div class="mt-4 grid gap-6 lg:grid-cols-[1.1fr,.9fr]">
        <div class="card overflow-hidden bg-sand">
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="h-full max-h-[440px] w-full object-cover">
        </div>

        <div class="flex flex-col">
            <div class="flex items-start justify-between gap-3">
                @if ($product->category)
                    <span class="pill w-fit bg-clay-soft text-clay">{{ $product->category->name }}</span>
                @endif
                <button data-fav data-type="product" data-id="{{ $product->id }}" aria-label="حفظ في المفضلة"
                        class="grid h-10 w-10 shrink-0 place-items-center rounded-full border border-line bg-white text-clay transition hover:border-clay/40">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="{{ $isFavorite ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 20s-7-4.3-9.3-8.3C1.2 8.9 2.6 5.5 6 5.5c2 0 3.2 1.2 4 2.3.8-1.1 2-2.3 4-2.3 3.4 0 4.8 3.4 3.3 6.2C19 15.7 12 20 12 20z"/>
                    </svg>
                </button>
            </div>
            <h1 class="mt-3 font-display text-3xl">{{ $product->name }}</h1>
            @if ($product->reviews->isNotEmpty())
                <div class="mt-2 flex items-center gap-2 text-sm">
                    <span class="flex text-ochre">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="{{ $i <= round($product->averageRating()) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.6"><path d="M12 3.5l2.1 4.8 5.2.5-3.9 3.5 1.1 5.1L12 14.7l-4.5 2.7 1.1-5.1-3.9-3.5 5.2-.5z"/></svg>
                        @endfor
                    </span>
                    <b class="text-ink">{{ $product->averageRating() }}</b>
                    <span class="text-muted">({{ $product->reviews->count() }} تقييم)</span>
                </div>
            @endif
            @if ($product->style)
                <p class="mt-1 text-sm text-muted">الأسلوب: {{ $product->style }}</p>
            @endif
            <p class="mt-4 leading-relaxed text-ink/80">{{ $product->description }}</p>

            <div class="mt-5 flex items-baseline gap-2">
                @if ($product->priceOnRequest())
                    <span class="text-2xl font-bold text-clay">السعر عند الطلب</span>
                @else
                    <span class="text-3xl font-bold text-clay">{{ number_format($product->price) }}</span>
                    <span class="text-muted">ريال</span>
                @endif
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <form method="POST" action="{{ route('client.cart.add', $product) }}">
                    @csrf
                    <button class="btn-primary" data-busy-text="جارٍ الإضافة…">
                        @include('partials.icon', ['name' => 'cart', 'class' => 'h-4 w-4'])
                        أضيفي إلى السلة
                    </button>
                </form>
                <a href="{{ route('client.cart') }}" class="btn-ghost">عرض السلة</a>
            </div>

            <div class="mt-6 grid grid-cols-3 gap-3 border-t border-line pt-5 text-center text-sm">
                <div><p class="font-bold text-ink">توصيل</p><p class="text-muted">خلال 5 أيام</p></div>
                <div><p class="font-bold text-ink">ضمان</p><p class="text-muted">سنتان</p></div>
                <div><p class="font-bold text-ink">تركيب</p><p class="text-muted">مجاني</p></div>
            </div>
        </div>
    </div>

    {{-- Reviews --}}
    <section class="mt-10 grid gap-6 lg:grid-cols-[1fr,1.2fr]">
        <div class="card h-fit p-6">
            <h2 class="font-display text-xl">{{ $userReview ? 'عدّلي تقييمك' : 'قيّمي هذا المنتج' }}</h2>
            <form method="POST" action="{{ route('client.store.review', $product) }}" class="mt-4 space-y-4">
                @csrf
                <div class="flex flex-row-reverse justify-end gap-1" dir="ltr">
                    @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="peer sr-only"
                               @checked(old('rating', $userReview?->rating) == $i) required>
                        <label for="star{{ $i }}" class="cursor-pointer text-2xl text-line transition peer-checked:text-ochre hover:text-ochre [&:hover~label]:text-ochre">★</label>
                    @endfor
                </div>
                <textarea name="comment" rows="3" maxlength="400" class="field" placeholder="شاركينا رأيك (اختياري)">{{ old('comment', $userReview?->comment) }}</textarea>
                <button class="btn-primary w-full" data-busy-text="جارٍ الإرسال…">{{ $userReview ? 'تحديث التقييم' : 'إرسال التقييم' }}</button>
            </form>
        </div>

        <div class="card p-6">
            <h2 class="font-display text-xl">آراء العملاء</h2>
            @if ($product->reviews->isEmpty())
                <p class="mt-4 text-sm text-muted">لا توجد تقييمات بعد — كوني أول من يشارك رأيه.</p>
            @else
                <div class="mt-4 space-y-4">
                    @foreach ($product->reviews->take(4) as $review)
                        <div class="border-b border-line pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <span class="grid h-9 w-9 place-items-center rounded-full bg-sand text-sm font-bold text-ink">{{ $review->user->initials() }}</span>
                                    <div class="leading-tight">
                                        <b class="block text-sm text-ink">{{ $review->user->name }}</b>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <span class="flex text-ochre">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.6"><path d="M12 3.5l2.1 4.8 5.2.5-3.9 3.5 1.1 5.1L12 14.7l-4.5 2.7 1.1-5.1-3.9-3.5 5.2-.5z"/></svg>
                                    @endfor
                                </span>
                            </div>
                            @if ($review->comment)
                                <p class="mt-2 text-sm leading-relaxed text-ink/80">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="mt-10">
            <h2 class="font-display text-2xl">قطع مشابهة</h2>
            <div class="mt-4 grid gap-5 sm:grid-cols-3">
                @foreach ($related as $item)
                    <a href="{{ route('client.store.show', $item) }}" class="card group overflow-hidden transition hover:-translate-y-1 hover:shadow-soft">
                        <div class="aspect-[4/3] overflow-hidden bg-sand">
                            <img src="{{ $item->imageUrl() }}" alt="{{ $item->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        </div>
                        <div class="flex items-center justify-between gap-2 p-4">
                            <h3 class="font-display text-base">{{ $item->name }}</h3>
                            <span class="whitespace-nowrap text-sm font-bold text-clay">{{ $item->priceLabel() }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection

@push('scripts')
<script>
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
        } catch (e) {}
    }));
</script>
@endpush
