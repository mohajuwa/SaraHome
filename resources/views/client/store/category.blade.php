@extends('layouts.app')
@section('title', $category->name)
@section('heading', 'المتجر')

@section('content')
    <div class="flex flex-wrap items-center gap-2 text-sm text-muted">
        <a href="{{ route('client.store') }}" class="hover:text-clay">المتجر</a>
        @if ($category->parent)
            <span>/</span>
            <a href="{{ route('client.store.category', $category->parent) }}" class="hover:text-clay">{{ $category->parent->name }}</a>
        @endif
        <span>/</span>
        <b class="text-ink">{{ $category->name }}</b>
    </div>

    <div class="mt-3">
        <h1 class="font-display text-3xl">{{ $category->name }}</h1>
        @if ($category->description)
            <p class="mt-1 text-muted">{{ $category->description }}</p>
        @endif
    </div>

    {{-- Sub-categories (e.g. under غرف النوم) --}}
    @if ($children->isNotEmpty())
        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($children as $child)
                <a href="{{ route('client.store.category', $child) }}"
                   class="card group overflow-hidden transition hover:-translate-y-1 hover:shadow-soft">
                    <div class="relative aspect-[16/10] overflow-hidden bg-sand">
                        <img src="{{ asset('images/'.$child->image_path) }}" alt="{{ $child->name }}"
                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute right-3 top-3 pill bg-white/90 text-ink">{{ $child->products()->count() }} منتج</span>
                    </div>
                    <div class="flex items-center justify-between gap-2 p-5">
                        <h3 class="font-display text-lg">{{ $child->name }}</h3>
                        <span class="text-clay">←</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    {{-- Products in this category --}}
    @if ($products->isNotEmpty())
        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($products as $product)
                <a href="{{ route('client.store.show', $product) }}"
                   class="card group overflow-hidden transition hover:-translate-y-1 hover:shadow-soft">
                    <div class="relative aspect-[4/3] overflow-hidden bg-sand">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}"
                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @if ($product->is_featured)
                            <span class="absolute right-3 top-3 pill bg-clay text-white">مميّز</span>
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
    @elseif ($children->isEmpty())
        <div class="mt-6 card p-10 text-center text-muted">لا توجد منتجات في هذا القسم بعد.</div>
    @endif
@endsection
