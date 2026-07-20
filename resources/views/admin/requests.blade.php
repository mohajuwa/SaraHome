@extends('layouts.app')
@section('title', 'الطلبات')
@section('heading', 'الطلبات')

@section('content')
    <div>
        <p class="text-xs font-bold tracking-[.2em] text-clay">مسار العمل</p>
        <h1 class="mt-1 font-display text-3xl">طلبات التصميم</h1>
        <p class="mt-1 text-muted">تابع الطلبات الجديدة وغيّر حالتها أثناء العمل.</p>
    </div>

    @php
        $meta = [
            'new' => ['title' => 'جديدة', 'dot' => 'bg-ochre'],
            'in_review' => ['title' => 'قيد المراجعة', 'dot' => 'bg-clay'],
            'completed' => ['title' => 'مكتملة', 'dot' => 'bg-pine'],
        ];
    @endphp

    <div class="mt-6 grid gap-4 lg:grid-cols-3">
        @foreach ($meta as $key => $m)
            <section class="rounded-2xl bg-sand/50 p-4">
                <div class="mb-3 flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full {{ $m['dot'] }}"></span>
                    <h3 class="font-bold text-ink">{{ $m['title'] }}</h3>
                    <span class="pill bg-white text-muted">{{ $columns[$key]->count() }}</span>
                </div>

                <div class="space-y-3">
                    @forelse ($columns[$key] as $project)
                        <article class="card p-4">
                            <div class="flex items-center justify-between">
                                <b class="text-ink">{{ $project->name }}</b>
                                <span class="text-xs text-muted">{{ $project->created_at->translatedFormat('j M') }}</span>
                            </div>
                            <p class="mt-1 text-xs text-muted">{{ $project->user->name }} · {{ $project->room_type }} · {{ $project->style }}</p>
                            <form method="POST" action="{{ route('admin.requests.update', $project) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="field mt-3 text-sm">
                                    <option value="new" @selected($project->status === 'new')>جديد</option>
                                    <option value="in_review" @selected($project->status === 'in_review')>قيد المراجعة</option>
                                    <option value="completed" @selected($project->status === 'completed')>مكتمل</option>
                                </select>
                            </form>
                        </article>
                    @empty
                        <p class="rounded-xl border border-dashed border-line py-6 text-center text-xs text-muted">لا توجد طلبات</p>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
@endsection
