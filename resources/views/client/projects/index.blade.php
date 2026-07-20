@extends('layouts.app')
@section('title', 'مشاريعي')
@section('heading', 'مشاريعي')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-bold tracking-[.2em] text-clay">مساحتك الخاصة</p>
            <h1 class="mt-1 font-display text-3xl">مشاريعي</h1>
        </div>
        <button data-modal-open="project-modal" class="btn-primary">
            @include('partials.icon', ['name' => 'plus', 'class' => 'h-4 w-4'])
            مشروع جديد
        </button>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($projects as $project)
            @include('partials.project-card', ['project' => $project])
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-line py-16 text-center text-muted">
                لا توجد مشاريع بعد — ابدئي أول مشروع لك.
            </div>
        @endforelse

        <button data-modal-open="project-modal"
                class="flex min-h-[228px] flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-line text-muted transition hover:border-clay/50 hover:text-clay">
            <span class="grid h-11 w-11 place-items-center rounded-full bg-clay-soft text-clay">
                @include('partials.icon', ['name' => 'plus', 'class' => 'h-5 w-5'])
            </span>
            <b class="text-ink">إنشاء مشروع جديد</b>
        </button>
    </div>
@endsection

@push('modals')
    @include('partials.project-modal')
@endpush
