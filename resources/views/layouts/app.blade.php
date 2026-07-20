<!doctype html>
<html lang="ar" dir="rtl">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-canvas text-ink">
    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-30 flex items-center justify-between gap-4 border-b border-line bg-canvas/85 px-5 py-4 backdrop-blur sm:px-8">
                <div class="flex items-center gap-3">
                    <button data-sidebar-toggle class="text-ink lg:hidden" aria-label="القائمة">
                        @include('partials.icon', ['name' => 'menu'])
                    </button>
                    <div class="text-sm text-muted">
                        سارا هوم <span class="px-1 text-line">/</span>
                        <b class="text-ink">@yield('heading', 'الرئيسية')</b>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="relative grid h-10 w-10 place-items-center rounded-full border border-line bg-white text-ink transition hover:border-clay/40" aria-label="الإشعارات">
                        @include('partials.icon', ['name' => 'bell'])
                        <em class="absolute right-2.5 top-2.5 h-2 w-2 rounded-full bg-clay"></em>
                    </button>
                    <span class="grid h-10 w-10 place-items-center rounded-full bg-ink text-sm font-bold text-white">
                        {{ auth()->user()->initials() }}
                    </span>
                </div>
            </header>

            <main class="mx-auto w-full max-w-[1180px] flex-1 animate-fade-up px-5 py-8 sm:px-8">
                @yield('content')
            </main>
        </div>
    </div>

    @include('partials.flash')
    @stack('modals')
    @stack('scripts')
</body>
</html>
