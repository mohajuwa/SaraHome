@extends('layouts.guest')
@section('title', 'إنشاء حساب')

@section('content')
    <h1 class="font-display text-3xl text-ink">أنشئ حسابك</h1>
    <p class="mt-2 text-muted">ابدأ رحلتك مع سارا هوم خلال دقيقة.</p>

    <form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label class="mb-1.5 block text-sm font-bold">الاسم</label>
            <input name="name" value="{{ old('name') }}" required autofocus class="field" placeholder="سارة أحمد">
            @error('name')<p class="mt-1 text-xs font-bold text-clay">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-bold">البريد الإلكتروني</label>
            <input name="email" type="email" value="{{ old('email') }}" required class="field" placeholder="you@email.com">
            @error('email')<p class="mt-1 text-xs font-bold text-clay">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="mb-1.5 block text-sm font-bold">كلمة المرور</label>
                <input name="password" type="password" required class="field" placeholder="••••••••">
                @error('password')<p class="mt-1 text-xs font-bold text-clay">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-bold">تأكيد كلمة المرور</label>
                <input name="password_confirmation" type="password" required class="field" placeholder="••••••••">
            </div>
        </div>
        <button class="btn-primary w-full">إنشاء الحساب</button>
    </form>

    <p class="mt-6 text-center text-sm text-muted">
        لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="font-bold text-clay">سجّل الدخول</a>
    </p>
@endsection
