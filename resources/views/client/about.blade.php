@extends('layouts.app')
@section('title', 'خدماتنا')
@section('heading', 'خدماتنا')

@section('content')
    <section class="card relative overflow-hidden p-8 sm:p-10">
        <div class="max-w-2xl">
            <p class="text-xs font-bold tracking-[.2em] text-clay">من نحن</p>
            <h1 class="mt-3 font-display text-3xl leading-snug sm:text-4xl">
                نساعدك على تصوّر <span class="text-clay">مساحتك</span> قبل أن تلمسي أثاثة واحدة.
            </h1>
            <p class="mt-3 text-muted">
                سارا هوم منصّة تصميم داخلي تجمع بين ذكاء التوصية ولمسة المصمّم — لتحوّل صورة غرفتك
                إلى خطة متكاملة من الألوان والأثاث والإضاءة تناسب ذوقك وميزانيتك.
            </p>
        </div>
        <div class="pointer-events-none absolute -left-10 -top-10 h-48 w-48 rounded-full bg-clay-soft opacity-70"></div>
        <div class="pointer-events-none absolute -bottom-12 left-24 h-40 w-40 rounded-full bg-pine-soft opacity-60"></div>
    </section>

    <section class="mt-8">
        <h2 class="font-display text-2xl">ماذا نقدّم</h2>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            @foreach ($services as $s)
                <div class="card flex items-start gap-4 p-5">
                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-clay-soft text-clay">
                        @include('partials.icon', ['name' => $s['icon']])
                    </span>
                    <div>
                        <h3 class="font-display text-lg">{{ $s['title'] }}</h3>
                        <p class="mt-1 text-sm text-muted">{{ $s['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-8">
        <h2 class="font-display text-2xl">كيف تعمل المنصّة</h2>
        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($steps as $st)
                <div class="card p-5">
                    <span class="grid h-10 w-10 place-items-center rounded-full bg-ink text-sm font-bold text-white">{{ $st['n'] }}</span>
                    <h3 class="mt-3 font-display text-lg">{{ $st['title'] }}</h3>
                    <p class="mt-1 text-sm text-muted">{{ $st['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-8 grid gap-6 rounded-3xl bg-sand p-8 sm:grid-cols-3 sm:p-10">
        <div class="sm:col-span-2">
            <h2 class="font-display text-2xl">جاهزة نبدأ مساحتك؟</h2>
            <p class="mt-2 text-muted">ابدئي مشروعاً جديداً الآن، أو تصفّحي متجر الأثاث لاختيار قطعك المفضّلة.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3 sm:justify-end">
            <a href="{{ route('client.dashboard') }}" class="btn-primary">مشروع جديد</a>
            <a href="{{ route('client.store') }}" class="btn-ghost">زيارة المتجر</a>
        </div>
    </section>
@endsection
