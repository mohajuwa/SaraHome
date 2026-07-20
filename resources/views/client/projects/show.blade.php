@extends('layouts.app')
@section('title', $project->name)
@section('heading', 'تفاصيل المشروع')

@section('content')
    @php
        $statusStyles = [
            'completed' => 'bg-pine-soft text-pine',
            'in_review' => 'bg-clay-soft text-clay',
            'new' => 'bg-ochre-soft text-ochre',
        ][$project->status] ?? 'bg-ochre-soft text-ochre';
        $design = $project->design;
        $steps = ['new' => 'الطلب', 'in_review' => 'قيد التصميم', 'completed' => 'جاهز'];
        $order = array_keys($steps);
        $currentIndex = array_search($project->status, $order);
    @endphp

    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <a href="{{ route('client.projects.index') }}" class="text-sm text-muted hover:text-clay">→ العودة إلى مشاريعي</a>
            <h1 class="mt-2 font-display text-3xl">{{ $project->name }}</h1>
            <p class="mt-1 text-muted">{{ $project->style }} · {{ $project->room_type }} · {{ $project->budget }}</p>
        </div>
        <span class="pill {{ $statusStyles }}">{{ $project->statusLabel() }}</span>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1.55fr,1fr]">
        {{-- Left: room preview + generated design --}}
        <div class="space-y-6">
            <div class="card overflow-hidden">
                @if ($project->image_path)
                    <img src="{{ \Storage::url($project->image_path) }}" alt="{{ $project->name }}" class="h-64 w-full object-cover">
                @else
                    <div class="flex h-64 w-full items-center justify-center text-white"
                         style="background:linear-gradient(135deg,#E7D3BE 0%, #C15F3C 120%);">
                        @include('partials.icon', ['name' => 'image', 'class' => 'h-10 w-10 opacity-80'])
                    </div>
                @endif
            </div>

            @if ($design)
                <div class="card p-6">
                    <div class="flex items-center gap-2">
                        @include('partials.icon', ['name' => 'sparkle', 'class' => 'h-5 w-5 text-clay'])
                        <h2 class="font-display text-xl">لوحة الألوان المقترحة</h2>
                    </div>
                    <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        @foreach ($design->palette as $color)
                            <div>
                                <div class="h-20 rounded-2xl border border-line shadow-inner" style="background: {{ $color['hex'] }};"></div>
                                <p class="mt-2 text-sm font-bold text-ink">{{ $color['name'] }}</p>
                                <p dir="ltr" class="text-start text-xs text-muted">{{ $color['hex'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="font-display text-xl">الأثاث المقترح</h2>
                        <span class="pill bg-sand text-ink">التكلفة التقديرية: {{ number_format($design->estimated_cost) }} ريال</span>
                    </div>
                    <ul class="mt-4 divide-y divide-line">
                        @foreach ($design->furniture as $item)
                            <li class="flex items-center justify-between gap-4 py-3">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-clay-soft text-clay">
                                        @include('partials.icon', ['name' => 'check', 'class' => 'h-4 w-4'])
                                    </span>
                                    <div>
                                        <p class="font-bold text-ink">{{ $item['name'] }}</p>
                                        <p class="text-xs text-muted">{{ $item['note'] }}</p>
                                    </div>
                                </div>
                                <span class="whitespace-nowrap text-sm font-bold text-ink">{{ number_format($item['price']) }} ريال</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if ($suggestedProducts->isNotEmpty())
                    <div class="card p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                @include('partials.icon', ['name' => 'store', 'class' => 'h-5 w-5 text-clay'])
                                <h2 class="font-display text-xl">قطع متوفرة من متجرنا</h2>
                            </div>
                            <a href="{{ route('client.store') }}" class="text-sm font-bold text-clay">المتجر ←</a>
                        </div>
                        <p class="mt-1 text-sm text-muted">اخترناها لتناسب {{ $project->room_type }} — أضيفيها للسلة مباشرة.</p>
                        <div class="mt-4 grid gap-4 sm:grid-cols-3">
                            @foreach ($suggestedProducts as $sp)
                                <div class="overflow-hidden rounded-2xl border border-line">
                                    <a href="{{ route('client.store.show', $sp) }}" class="block aspect-[4/3] overflow-hidden bg-sand">
                                        <img src="{{ $sp->imageUrl() }}" alt="{{ $sp->name }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                                    </a>
                                    <div class="p-3">
                                        <p class="truncate text-sm font-bold text-ink">{{ $sp->name }}</p>
                                        <div class="mt-2 flex items-center justify-between gap-2">
                                            <span class="text-sm font-bold text-clay">{{ $sp->priceLabel() }}</span>
                                            <form method="POST" action="{{ route('client.cart.add', $sp) }}">
                                                @csrf
                                                <button class="pill bg-clay-soft text-clay hover:bg-clay hover:text-white" data-busy-text="…">+ للسلة</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <div class="card flex flex-col items-center justify-center gap-3 p-10 text-center">
                    <span class="grid h-14 w-14 place-items-center rounded-2xl bg-clay-soft text-clay">
                        @include('partials.icon', ['name' => 'sparkle', 'class' => 'h-7 w-7'])
                    </span>
                    <h2 class="font-display text-xl">لم يتم إنشاء التصميم بعد</h2>
                    <p class="max-w-sm text-sm text-muted">
                        اضغطي «أنشئ تصميمي» ليقوم سارا بتحليل ذوقك وميزانيتك واقتراح لوحة ألوان وأثاث وخطة إضاءة.
                    </p>
                    <form method="POST" action="{{ route('client.projects.generate', $project) }}">
                        @csrf
                        <button class="btn-primary mt-2" data-busy-text="جارٍ إنشاء التصميم…">أنشئ تصميمي</button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Right: smart action + lighting + progress --}}
        <div class="space-y-6">
            <div class="card p-6">
                <div class="flex items-center gap-2">
                    @include('partials.icon', ['name' => 'sparkle', 'class' => 'h-5 w-5 text-clay'])
                    <h3 class="font-bold">تصوّر سارا الذكي</h3>
                </div>
                <p class="mt-2 text-sm text-muted">يحلّل أسلوبك ومساحتك وميزانيتك ثم يقترح تنسيقاً متكاملاً.</p>
                <form method="POST" action="{{ route('client.projects.generate', $project) }}" class="mt-4">
                    @csrf
                    <button class="btn-primary w-full" data-busy-text="جارٍ إنشاء التصميم…">{{ $design ? 'إعادة إنشاء التصميم' : 'أنشئ تصميمي' }}</button>
                </form>

                @if ($design && $design->lighting)
                    <div class="mt-5 border-t border-line pt-4">
                        <p class="mb-2 text-sm font-bold">خطة الإضاءة</p>
                        <ul class="space-y-2">
                            @foreach ($design->lighting as $point)
                                <li class="flex items-start gap-2 text-sm text-ink/75">
                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-clay"></span>
                                    {{ $point }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            @if ($design && $design->summary)
                <div class="rounded-2xl bg-sand p-6">
                    <p class="text-xs font-bold tracking-[.2em] text-clay">ملخص التصوّر</p>
                    <p class="mt-2 text-sm leading-relaxed text-ink/80">{{ $design->summary }}</p>
                </div>
            @endif

            <div class="card p-6">
                <p class="mb-4 text-sm font-bold">مسار المشروع</p>
                <div class="flex items-center justify-between">
                    @foreach ($steps as $key => $label)
                        @php $i = array_search($key, $order); $done = $i <= $currentIndex; @endphp
                        <div class="flex flex-1 flex-col items-center gap-2">
                            <span class="grid h-9 w-9 place-items-center rounded-full text-sm font-bold {{ $done ? 'bg-clay text-white' : 'bg-sand text-muted' }}">{{ $i + 1 }}</span>
                            <span class="text-xs {{ $done ? 'text-ink' : 'text-muted' }}">{{ $label }}</span>
                        </div>
                        @if (! $loop->last)
                            <div class="mb-5 h-0.5 flex-1 {{ $i < $currentIndex ? 'bg-clay' : 'bg-sand' }}"></div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
