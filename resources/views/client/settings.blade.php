@extends('layouts.app')
@section('title', 'الإعدادات')
@section('heading', 'الإعدادات')

@section('content')
    <div class="max-w-2xl">
        <p class="text-xs font-bold tracking-[.2em] text-clay">حسابك</p>
        <h1 class="mt-1 font-display text-3xl">الإعدادات</h1>

        <form method="POST" action="{{ route('client.settings.update') }}" class="card mt-6 space-y-4 p-6">
            @csrf
            @method('PUT')

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-bold">الاسم</label>
                    <input name="name" value="{{ old('name', $user->name) }}" required class="field">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-bold">رقم الجوال</label>
                    <input name="phone" value="{{ old('phone', $user->phone) }}" class="field" placeholder="+9665xxxxxxxx" dir="ltr">
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-bold">الأسلوب المفضّل</label>
                    <select name="preferred_style" class="field">
                        <option value="">— اختاري —</option>
                        @foreach (['مودرن دافئ', 'سكندنافي', 'بسيط', 'كلاسيكي'] as $s)
                            <option @selected($user->preferred_style === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-bold">نطاق الميزانية</label>
                    <select name="budget_range" class="field">
                        <option value="">— اختاري —</option>
                        @foreach (['أقل من 5,000 ريال', '5,000 - 10,000 ريال', '10,000 - 20,000 ريال', 'أكثر من 10,000 ريال'] as $b)
                            <option @selected($user->budget_range === $b)>{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-2">
                <button class="btn-primary">حفظ التفضيلات</button>
            </div>
        </form>
    </div>
@endsection
