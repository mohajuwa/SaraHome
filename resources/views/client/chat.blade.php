@extends('layouts.app')
@section('title', 'الدردشة المباشرة')
@section('heading', 'الدردشة المباشرة')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[.85fr,1.6fr]">
        <aside class="card h-fit p-4">
            <div class="flex items-center gap-2 rounded-xl border border-line bg-canvas px-3 py-2 text-muted">
                <span class="text-sm">⌕</span>
                <input class="w-full border-0 bg-transparent p-0 text-sm focus:ring-0" placeholder="ابحثي في المحادثات">
            </div>
            <button class="mt-3 flex w-full items-center gap-3 rounded-2xl bg-sand p-3 text-start">
                <span class="grid h-10 w-10 place-items-center rounded-full bg-pine text-white">م</span>
                <span class="min-w-0 flex-1 leading-tight">
                    <b class="block text-ink">مها، مصممة داخلية</b>
                    <small class="text-muted">أرسلت لك لوحة الألوان</small>
                </span>
                <em class="text-xs text-muted">10:20</em>
            </button>
            <button class="mt-1 flex w-full items-center gap-3 rounded-2xl p-3 text-start hover:bg-sand/60">
                <span class="grid h-10 w-10 place-items-center rounded-full bg-clay-soft text-clay">S</span>
                <span class="min-w-0 flex-1 leading-tight">
                    <b class="block text-ink">فريق سارا هوم</b>
                    <small class="text-muted">نحن هنا لمساعدتك</small>
                </span>
                <em class="text-xs text-muted">أمس</em>
            </button>
        </aside>

        <section class="card flex min-h-[70vh] flex-col">
            <header class="flex items-center justify-between border-b border-line p-4">
                <div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-full bg-pine text-white">م</span>
                    <div class="leading-tight">
                        <b class="block text-ink">مها، مصممة داخلية</b>
                        <small class="text-pine">● متصلة الآن</small>
                    </div>
                </div>
                @if ($project)
                    <a href="{{ route('client.projects.show', $project) }}" class="text-sm font-bold text-clay">عرض المشروع ←</a>
                @endif
            </header>

            <div class="flex flex-1 flex-col gap-3 overflow-y-auto p-5">
                @forelse ($messages as $m)
                    <div class="flex {{ $m->is_from_designer ? 'justify-start' : 'justify-end' }}">
                        <div class="max-w-[75%] rounded-2xl px-4 py-2.5 text-sm {{ $m->is_from_designer ? 'bg-sand text-ink' : 'bg-clay text-white' }}">
                            <p>{{ $m->body }}</p>
                            <small class="mt-1 block text-[11px] {{ $m->is_from_designer ? 'text-muted' : 'text-white/70' }}">
                                {{ $m->created_at->translatedFormat('g:i A') }}
                            </small>
                        </div>
                    </div>
                @empty
                    <p class="m-auto text-sm text-muted">لا توجد رسائل بعد. ابدئي المحادثة أدناه.</p>
                @endforelse
            </div>

            @if ($project)
                <form method="POST" action="{{ route('client.chat.store') }}" class="flex items-center gap-2 border-t border-line p-3">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input name="body" required autocomplete="off" class="field flex-1" placeholder="اكتبي رسالتك هنا...">
                    <button class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-clay text-white transition hover:bg-clay-dark" aria-label="إرسال">
                        @include('partials.icon', ['name' => 'arrow', 'class' => 'h-5 w-5 rotate-180'])
                    </button>
                </form>
            @endif
        </section>
    </div>
@endsection
