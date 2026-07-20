@extends('layouts.app')
@section('title', 'لوحة التحكم')
@section('heading', 'لوحة التحكم')

@section('content')
    <div>
        <p class="text-xs font-bold tracking-[.2em] text-clay">نظرة عامة</p>
        <h1 class="mt-1 font-display text-3xl">صباح الخير، مشرف سارا</h1>
        <p class="mt-1 text-muted">إليك ملخص نشاط المنصة اليوم.</p>
    </div>

    @php
        $cards = [
            ['label' => 'إجمالي العملاء', 'value' => number_format($metrics['clients']), 'icon' => 'clients', 'bg' => 'bg-clay-soft', 'fg' => 'text-clay'],
            ['label' => 'المشاريع النشطة', 'value' => number_format($metrics['active']), 'icon' => 'projects', 'bg' => 'bg-ochre-soft', 'fg' => 'text-ochre'],
            ['label' => 'تصاميم مكتملة', 'value' => number_format($metrics['completed']), 'icon' => 'check', 'bg' => 'bg-pine-soft', 'fg' => 'text-pine'],
            ['label' => 'متوسط الرضا', 'value' => $metrics['satisfaction'] . ' ★', 'icon' => 'sparkle', 'bg' => 'bg-sand', 'fg' => 'text-ink'],
        ];
    @endphp
    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($cards as $c)
            <div class="card p-5">
                <span class="grid h-11 w-11 place-items-center rounded-2xl {{ $c['bg'] }} {{ $c['fg'] }}">
                    @include('partials.icon', ['name' => $c['icon']])
                </span>
                <p class="mt-4 text-sm text-muted">{{ $c['label'] }}</p>
                <p class="mt-1 font-display text-2xl text-ink">{{ $c['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1.4fr,1fr]">
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold tracking-[.2em] text-clay">آخر 7 أيام</p>
                    <h2 class="mt-1 font-display text-xl">نشاط المشاريع</h2>
                </div>
                <span class="pill bg-pine-soft text-pine">محدّث</span>
            </div>
            @php $max = max($activity->pluck('count')->max(), 1); @endphp
            <div class="mt-6 flex h-52 items-end gap-3">
                @foreach ($activity as $a)
                    <div class="flex flex-1 flex-col items-center justify-end gap-2">
                        <div class="w-full rounded-t-xl bg-gradient-to-t from-clay/70 to-clay" style="height: {{ max(12, round($a['count'] / $max * 170)) }}px;"></div>
                        <span class="text-xs text-muted">{{ $a['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-xl">أحدث الطلبات</h2>
                <a href="{{ route('admin.requests') }}" class="text-sm font-bold text-clay">عرض الكل</a>
            </div>
            <div class="mt-4 space-y-3">
                @foreach ($requests as $project)
                    @php
                        $s = ['completed' => 'bg-pine-soft text-pine', 'in_review' => 'bg-clay-soft text-clay', 'new' => 'bg-ochre-soft text-ochre'][$project->status];
                    @endphp
                    <div class="flex items-center gap-3">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-sand font-bold text-ink">{{ $project->user->initials() }}</span>
                        <div class="min-w-0 flex-1 leading-tight">
                            <b class="block truncate text-ink">{{ $project->name }}</b>
                            <small class="text-muted">{{ $project->room_type }} · {{ $project->style }}</small>
                        </div>
                        <span class="pill {{ $s }}">{{ $project->statusLabel() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ===== Store sales report ===== --}}
    <div class="mt-8 flex items-end justify-between">
        <div>
            <p class="text-xs font-bold tracking-[.2em] text-clay">تقارير المتجر</p>
            <h2 class="mt-1 font-display text-2xl">المبيعات والطلبات</h2>
        </div>
        <a href="{{ route('admin.orders') }}" class="text-sm font-bold text-clay">إدارة الطلبات ←</a>
    </div>

    <div class="mt-4 grid gap-6 lg:grid-cols-[1fr,1.4fr]">
        <div class="grid grid-cols-2 gap-4">
            <div class="card col-span-2 bg-ink p-5 text-white">
                <p class="text-sm text-white/60">إجمالي الإيرادات</p>
                <p class="mt-1 font-display text-3xl">{{ number_format($sales['revenue']) }} <span class="text-base text-white/60">ريال</span></p>
                <p class="mt-2 text-xs text-white/50">من {{ $sales['orders'] }} طلباً (بدون الملغية)</p>
            </div>
            <div class="card p-5">
                <p class="text-sm text-muted">طلبات جديدة</p>
                <p class="mt-1 font-display text-2xl text-ochre">{{ $sales['new'] }}</p>
            </div>
            <div class="card p-5">
                <p class="text-sm text-muted">تم توصيلها</p>
                <p class="mt-1 font-display text-2xl text-pine">{{ $sales['delivered'] }}</p>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="font-display text-xl">الأكثر مبيعاً</h3>
            @if ($topProducts->isEmpty())
                <p class="mt-4 text-sm text-muted">لا توجد مبيعات بعد — أول طلب بيظهر هنا.</p>
            @else
                @php $maxSold = max($topProducts->max('sold'), 1); @endphp
                <div class="mt-4 space-y-4">
                    @foreach ($topProducts as $tp)
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <b class="text-ink">{{ $tp->name }}</b>
                                <span class="text-muted">{{ $tp->sold }} قطعة · {{ number_format($tp->revenue) }} ريال</span>
                            </div>
                            <div class="mt-1.5 h-2.5 overflow-hidden rounded-full bg-sand">
                                <div class="h-full rounded-full bg-gradient-to-l from-clay to-ochre"
                                     style="width: {{ round($tp->sold / $maxSold * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
