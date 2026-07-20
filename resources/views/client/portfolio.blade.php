@extends('layouts.app')
@section('title', 'معرض أعمالنا')
@section('heading', 'معرض أعمالنا')

@section('content')
    <div>
        <p class="text-xs font-bold tracking-[.2em] text-clay">قصص مساحات حقيقية</p>
        <h1 class="mt-1 font-display text-3xl">معرض أعمالنا</h1>
        <p class="mt-1 max-w-xl text-muted">نماذج من مشاريع نفّذها فريق سارا هوم — كل مساحة تحمل قصة ذوق وميزانية مختلفة.</p>
    </div>

    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
        @foreach ($stats as $s)
            <div class="card p-5 text-center">
                <p class="font-display text-3xl text-clay">{{ $s['value'] }}</p>
                <p class="mt-1 text-sm text-muted">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 sm:grid-cols-2">
        @foreach ($projects as $p)
            <article class="card group overflow-hidden">
                <div class="relative aspect-[16/10] overflow-hidden bg-sand">
                    <img src="{{ asset('images/'.$p['image']) }}" alt="{{ $p['title'] }}"
                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-2 bg-gradient-to-t from-ink/70 to-transparent p-4">
                        <div class="text-white">
                            <span class="pill bg-white/20 text-white backdrop-blur">{{ $p['style'] }}</span>
                            <h3 class="mt-2 font-display text-xl drop-shadow">{{ $p['title'] }}</h3>
                        </div>
                        <span class="pill bg-white/90 text-ink">{{ $p['area'] }}</span>
                    </div>
                </div>
                <div class="p-5">
                    <p class="text-xs font-bold tracking-wider text-clay">{{ $p['room'] }}</p>
                    <p class="mt-1 text-sm leading-relaxed text-ink/80">{{ $p['note'] }}</p>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-8 rounded-3xl bg-ink p-8 text-center text-white sm:p-10">
        <h2 class="font-display text-2xl">مساحتك القادمة تبدأ هنا</h2>
        <p class="mt-2 text-white/70">ارفعي صورة غرفتك ودعينا نقترح لكِ تصميماً مثل هذه المشاريع.</p>
        <a href="{{ route('client.dashboard') }}" class="btn-primary mt-5">ابدئي مشروعك</a>
    </div>
@endsection
