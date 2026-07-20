@extends('layouts.guest')
@section('title', 'تسجيل الدخول')

@section('content')
    <h1 class="font-display text-3xl text-ink">مرحباً بعودتك</h1>
    <p class="mt-2 text-muted">سجّل الدخول لمتابعة تصاميمك.</p>

    <form method="POST" action="{{ route('login.attempt') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label class="mb-1.5 block text-sm font-bold">البريد الإلكتروني</label>
            <input name="email" type="email" value="{{ old('email') }}" required autofocus
                   class="field" placeholder="you@email.com">
            @error('email')<p class="mt-1 text-xs font-bold text-clay">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-bold">كلمة المرور</label>
            <input name="password" type="password" required class="field" placeholder="••••••••">
        </div>
        <label class="flex items-center gap-2 text-sm text-muted">
            <input type="checkbox" name="remember" class="rounded border-line text-clay focus:ring-clay/30">
            تذكّرني
        </label>
        <button class="btn-primary w-full">تسجيل الدخول</button>
    </form>

    <p class="mt-6 text-center text-sm text-muted">
        ليس لديك حساب؟ <a href="{{ route('register') }}" class="font-bold text-clay">أنشئ حساباً جديداً</a>
    </p>

    <div class="mt-8 rounded-2xl border border-line bg-white p-4 text-sm">
        <p class="font-bold text-ink">حسابات تجريبية</p>
        <p class="mt-1 text-muted">عميل: <span dir="ltr">sara@serahome.test</span></p>
        <p class="text-muted">مشرف: <span dir="ltr">admin@serahome.test</span></p>
        <p class="text-muted">كلمة المرور: <span dir="ltr">password</span></p>
    </div>
@endsection
