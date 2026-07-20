@extends('layouts.app')
@section('title', 'إدارة المنتجات')
@section('heading', 'المنتجات')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-3xl">إدارة المنتجات</h1>
            <p class="mt-1 text-muted">{{ $products->count() }} منتجاً في المتجر.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary">
            @include('partials.icon', ['name' => 'plus', 'class' => 'h-4 w-4'])
            منتج جديد
        </a>
    </div>

    <div class="card mt-6 overflow-x-auto">
        <table class="w-full min-w-[720px] text-sm">
            <thead>
                <tr class="border-b border-line text-start text-muted">
                    <th class="p-4 text-start">المنتج</th>
                    <th class="p-4 text-start">القسم</th>
                    <th class="p-4 text-start">السعر</th>
                    <th class="p-4 text-start">مميّز</th>
                    <th class="p-4 text-start">إجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @foreach ($products as $product)
                    <tr>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <span class="h-12 w-16 shrink-0 overflow-hidden rounded-lg bg-sand">
                                    <img src="{{ $product->imageUrl() }}" alt="" class="h-full w-full object-cover">
                                </span>
                                <b class="text-ink">{{ $product->name }}</b>
                            </div>
                        </td>
                        <td class="p-4 text-muted">{{ $product->category?->name ?? '—' }}</td>
                        <td class="p-4 font-bold text-ink">{{ $product->priceLabel() }}</td>
                        <td class="p-4">{{ $product->is_featured ? '⭐' : '—' }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="pill border border-line bg-white hover:border-clay/40">تعديل</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                      onsubmit="return confirm('حذف «{{ $product->name }}»؟');">
                                    @csrf @method('DELETE')
                                    <button class="pill bg-sand text-ink hover:bg-clay-soft hover:text-clay">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
