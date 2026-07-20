@extends('layouts.app')
@php($editing = $product->exists)
@section('title', $editing ? 'تعديل منتج' : 'منتج جديد')
@section('heading', 'المنتجات')

@section('content')
    <a href="{{ route('admin.products') }}" class="text-sm text-muted hover:text-clay">→ العودة إلى المنتجات</a>
    <h1 class="mt-2 font-display text-3xl">{{ $editing ? "تعديل: {$product->name}" : 'إضافة منتج جديد' }}</h1>

    @if ($errors->any())
        <div class="mt-4 rounded-2xl bg-clay-soft p-4 text-sm text-clay">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" enctype="multipart/form-data" class="card mt-6 max-w-2xl space-y-4 p-6"
          action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-line bg-white py-6 text-center text-muted transition hover:border-clay/50">
            @if ($editing)
                <img src="{{ $product->imageUrl() }}" alt="" class="h-28 w-full rounded-xl object-cover">
                <span class="text-xs">اضغط لاستبدال الصورة (JPG/PNG/SVG)</span>
            @else
                @include('partials.icon', ['name' => 'image', 'class' => 'h-7 w-7 text-clay'])
                <span class="text-sm font-bold text-ink">صورة المنتج</span>
                <span class="text-xs">اختياري — تُستخدم صورة افتراضية إن تُركت فارغة</span>
            @endif
            <input name="image" type="file" accept="image/*" class="hidden">
        </label>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-bold">اسم المنتج</label>
                <input name="name" required maxlength="80" class="field" value="{{ old('name', $product->name) }}">
            </div>
            <div>
                <label class="mb-1 block text-sm font-bold">القسم</label>
                <select name="category_id" required class="field">
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>
                            {{ $cat->parent ? $cat->parent->name.' / ' : '' }}{{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1 block text-sm font-bold">السعر (ريال)</label>
                <input name="price" type="number" required min="0" max="1000000" class="field" value="{{ old('price', $product->price) }}">
            </div>
            <div>
                <label class="mb-1 block text-sm font-bold">الأسلوب (اختياري)</label>
                <input name="style" maxlength="40" class="field" value="{{ old('style', $product->style) }}" placeholder="مودرن دافئ، سكندنافي…">
            </div>
        </div>

        <div>
            <label class="mb-1 block text-sm font-bold">الوصف</label>
            <textarea name="description" rows="3" maxlength="500" class="field">{{ old('description', $product->description) }}</textarea>
        </div>

        <label class="flex items-center gap-2 text-sm font-bold">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))
                   class="rounded border-line text-clay focus:ring-clay/30">
            منتج مميّز (يظهر في واجهة المتجر)
        </label>

        <button class="btn-primary w-full" data-busy-text="جارٍ الحفظ…">{{ $editing ? 'حفظ التعديلات' : 'إضافة المنتج' }}</button>
    </form>
@endsection
