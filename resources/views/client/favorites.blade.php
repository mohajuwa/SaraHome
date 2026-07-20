@extends('layouts.app')
@section('title', 'مفضلتي')
@section('heading', 'مفضلتي')

@section('content')
    <h1 class="font-display text-3xl">مفضلتي</h1>
    <p class="mt-1 text-muted">كل ما أعجبك من قطع وأفكار، في مكان واحد.</p>

    @if ($products->isEmpty() && $inspirations->isEmpty())
        <div class="card mt-6 flex flex-col items-center gap-3 p-10 text-center">
            <span class="grid h-14 w-14 place-items-center rounded-2xl bg-clay-soft text-clay">
                @include('partials.icon', ['name' => 'heart', 'class' => 'h-7 w-7'])
            </span>
            <h2 class="font-display text-xl">ما حفظتي شي بعد</h2>
            <p class="max-w-sm text-sm text-muted">اضغطي على القلب في المتجر أو معرض الإلهام وبيظهر هنا.</p>
            <div class="mt-2 flex gap-2">
                <a href="{{ route('client.store') }}" class="btn-primary">المتجر</a>
                <a href="{{ route('client.inspiration') }}" class="btn-ghost">معرض الإلهام</a>
            </div>
        </div>
    @endif

    @if ($products->isNotEmpty())
        <h2 class="mt-7 font-display text-2xl">قطع أعجبتك</h2>
        <div class="mt-4 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($products as $product)
                <a href="{{ route('client.store.show', $product) }}"
                   class="card group overflow-hidden transition hover:-translate-y-1 hover:shadow-soft">
                    <div class="relative aspect-[4/3] overflow-hidden bg-sand">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}"
                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @if ($product->category)
                            <span class="absolute right-3 top-3 pill bg-white/90 text-ink">{{ $product->category->name }}</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between gap-2 p-4">
                        <h3 class="font-display text-lg">{{ $product->name }}</h3>
                        <span class="whitespace-nowrap font-bold text-clay">{{ $product->priceLabel() }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    @if ($inspirations->isNotEmpty())
        <h2 class="mt-8 font-display text-2xl">أفكار ألهمتك</h2>
        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($inspirations as $insp)
                <div class="group relative h-48 overflow-hidden rounded-2xl" style="background:{{ $insp->accent_color }};">
                    @if ($insp->image_path)
                        <img src="{{ asset('images/'.$insp->image_path) }}" alt="{{ $insp->title }}"
                             class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    @endif
                    <div class="absolute inset-0" style="background:linear-gradient(180deg, transparent 40%, rgba(43,38,34,.5));"></div>
                    <div class="absolute inset-x-0 bottom-0 p-4 text-white">
                        <span class="pill bg-white/20 backdrop-blur">{{ $insp->style }}</span>
                        <h3 class="mt-1.5 font-display text-lg drop-shadow">{{ $insp->title }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
