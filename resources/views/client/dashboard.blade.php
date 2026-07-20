@extends('layouts.app')
@section('title', 'الرئيسية')
@section('heading', 'الرئيسية')

@section('content')
    @php $first = explode(' ', auth()->user()->name)[0]; @endphp

    <section class="card relative overflow-hidden p-7 sm:p-9">
        <div class="grid items-center gap-8 lg:grid-cols-[1.1fr,.9fr]">
            <div>
                <p class="text-xs font-bold tracking-[.2em] text-clay">مساحتك، بأسلوبك</p>
                <h1 class="mt-3 font-display text-3xl leading-snug sm:text-4xl">
                    أهلاً {{ $first }}،<br><span class="text-clay">لنصمّم بيتاً تحبّينه.</span>
                </h1>
                <p class="mt-3 max-w-md text-muted">
                    ارفعي صورة غرفتك، حدّدي ذوقك وميزانيتك، ودعي سارا هوم تقترح تنسيقاً مصمّماً لأجلك.
                </p>
                <button data-modal-open="project-modal" class="btn-primary mt-6">
                    @include('partials.icon', ['name' => 'plus', 'class' => 'h-4 w-4'])
                    ابدئي مشروعاً جديداً
                </button>
            </div>

            <div class="relative hidden h-60 lg:block">
                <div class="absolute inset-0 rounded-3xl" style="background:linear-gradient(135deg,#EFE5D8,#F6E4DB);"></div>
                <div class="absolute right-7 top-6 h-16 w-16 rounded-full bg-ochre/80"></div>
                <div class="absolute left-8 top-7 h-24 w-32 rounded-xl border-4 border-white/80 bg-white/40"></div>
                <div class="absolute bottom-7 left-10 h-20 w-28 rounded-t-[2.5rem] bg-clay"></div>
                <div class="absolute bottom-7 left-10 h-4 w-40 rounded-full bg-white/60"></div>
                <div class="absolute bottom-11 right-10 h-16 w-1.5 rounded bg-pine"></div>
                <div class="absolute bottom-[104px] right-7 h-8 w-8 rounded-full bg-pine/80"></div>
                <div class="absolute bottom-[104px] right-12 h-7 w-7 rounded-full bg-pine/60"></div>
            </div>
        </div>
    </section>

    <section class="mt-8">
        <div class="flex items-end justify-between">
            <div>
                <p class="text-xs font-bold tracking-[.2em] text-clay">متابعة سريعة</p>
                <h2 class="mt-1 font-display text-2xl">مشاريعك الأخيرة</h2>
            </div>
            <a href="{{ route('client.projects.index') }}" class="text-sm font-bold text-clay">عرض الكل ←</a>
        </div>

        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($recent as $project)
                @include('partials.project-card', ['project' => $project])
            @endforeach

            <button data-modal-open="project-modal"
                    class="flex min-h-[228px] flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-line text-muted transition hover:border-clay/50 hover:text-clay">
                <span class="grid h-11 w-11 place-items-center rounded-full bg-clay-soft text-clay">
                    @include('partials.icon', ['name' => 'plus', 'class' => 'h-5 w-5'])
                </span>
                <b class="text-ink">إنشاء مشروع جديد</b>
                <small>ابدئي بخطوة بسيطة</small>
            </button>
        </div>
    </section>

    <section class="mt-8 flex items-start gap-4 rounded-2xl bg-pine-soft p-6">
        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-pine text-white">
            @include('partials.icon', ['name' => 'sparkle', 'class' => 'h-6 w-6'])
        </span>
        <div>
            <p class="text-xs font-bold tracking-[.2em] text-pine">نصيحة سارا</p>
            <h3 class="mt-1 font-bold text-ink">ابدئي بقطعة محورية واحدة</h3>
            <p class="mt-1 text-sm text-ink/70">
                اختاري سجادة أو كنبة أو لوحة ألوان، ثم ابنِي بقية التفاصيل حولها لتحقيق انسجام متوازن.
            </p>
        </div>
    </section>
@endsection

@push('modals')
    @include('partials.project-modal')
@endpush
