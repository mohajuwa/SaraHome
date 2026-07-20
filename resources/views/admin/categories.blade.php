@extends('layouts.app')
@section('title', 'إدارة الأقسام')
@section('heading', 'الأقسام')

@section('content')
    <h1 class="font-display text-3xl">إدارة الأقسام</h1>
    <p class="mt-1 text-muted">أضف أقساماً رئيسية أو فرعية، وعدّل الأسماء والترتيب.</p>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1.4fr,1fr]">
        <div class="space-y-4">
            @foreach ($categories as $category)
                <div class="card p-5">
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="flex flex-wrap items-center gap-2">
                        @csrf @method('PUT')
                        <span class="h-10 w-14 shrink-0 overflow-hidden rounded-lg bg-sand">
                            <img src="{{ asset('images/'.$category->image_path) }}" alt="" class="h-full w-full object-cover">
                        </span>
                        <input name="name" value="{{ $category->name }}" maxlength="60" class="field !w-44 font-bold">
                        <input name="sort_order" type="number" value="{{ $category->sort_order }}" min="0" max="999" class="field !w-20 text-center" title="الترتيب">
                        <button class="pill border border-line bg-white hover:border-clay/40">حفظ</button>
                    </form>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="mt-1 inline"
                          onsubmit="return confirm('حذف قسم «{{ $category->name }}»؟');">
                        @csrf @method('DELETE')
                        <button class="text-xs text-muted hover:text-clay">حذف القسم</button>
                    </form>

                    @if ($category->children->isNotEmpty())
                        <div class="mt-3 space-y-2 border-t border-line pt-3">
                            @foreach ($category->children as $child)
                                <div class="flex flex-wrap items-center gap-2 pr-6">
                                    <span class="text-muted">↳</span>
                                    <form method="POST" action="{{ route('admin.categories.update', $child) }}" class="flex flex-wrap items-center gap-2">
                                        @csrf @method('PUT')
                                        <input name="name" value="{{ $child->name }}" maxlength="60" class="field !w-40 text-sm">
                                        <input name="sort_order" type="number" value="{{ $child->sort_order }}" min="0" max="999" class="field !w-18 text-center text-sm">
                                        <button class="pill border border-line bg-white text-xs hover:border-clay/40">حفظ</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $child) }}"
                                          onsubmit="return confirm('حذف «{{ $child->name }}»؟');">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-muted hover:text-clay">حذف</button>
                                    </form>
                                    <span class="text-xs text-muted">({{ $child->products()->count() }} منتج)</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="card h-fit p-6">
            <h2 class="font-display text-xl">قسم جديد</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="mt-4 space-y-3">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-bold">اسم القسم</label>
                    <input name="name" required maxlength="60" class="field" placeholder="مثال: الإضاءة">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-bold">القسم الأب (اختياري)</label>
                    <select name="parent_id" class="field">
                        <option value="">— قسم رئيسي —</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-bold">الترتيب</label>
                    <input name="sort_order" type="number" min="0" max="999" value="100" class="field">
                </div>
                <button class="btn-primary w-full" data-busy-text="جارٍ الإضافة…">إضافة القسم</button>
            </form>
        </div>
    </div>
@endsection
