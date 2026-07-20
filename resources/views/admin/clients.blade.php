@extends('layouts.app')
@section('title', 'العملاء')
@section('heading', 'العملاء')

@section('content')
    <div>
        <p class="text-xs font-bold tracking-[.2em] text-clay">إدارة الحسابات</p>
        <h1 class="mt-1 font-display text-3xl">العملاء</h1>
        <p class="mt-1 text-muted">{{ number_format($clients->count()) }} عميلاً مسجلاً في المنصة.</p>
    </div>

    <div class="card mt-6 overflow-hidden">
        <div class="grid grid-cols-[2fr,1fr,1.3fr,1fr] gap-4 border-b border-line bg-sand/60 px-5 py-3 text-xs font-bold text-muted">
            <span>العميل</span><span>المشاريع</span><span>آخر نشاط</span><span>الحالة</span>
        </div>
        @forelse ($clients as $client)
            <div class="grid grid-cols-[2fr,1fr,1.3fr,1fr] items-center gap-4 border-b border-line px-5 py-3.5 last:border-0">
                <div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-clay-soft font-bold text-clay">{{ $client->initials() }}</span>
                    <div class="min-w-0 leading-tight">
                        <b class="block truncate text-ink">{{ $client->name }}</b>
                        <small class="text-muted" dir="ltr">{{ $client->email }}</small>
                    </div>
                </div>
                <span class="text-ink">{{ $client->projects_count }}</span>
                <span class="text-sm text-muted">
                    {{ $client->projects_max_updated_at ? \Illuminate\Support\Carbon::parse($client->projects_max_updated_at)->diffForHumans() : '—' }}
                </span>
                <span><span class="pill bg-pine-soft text-pine">نشط</span></span>
            </div>
        @empty
            <div class="px-5 py-10 text-center text-muted">لا يوجد عملاء بعد.</div>
        @endforelse
    </div>
@endsection
