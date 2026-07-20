@php
    $user = auth()->user();
    $cartCount = array_sum(session('cart', []));

    // Live counters for the admin (cheap indexed counts).
    $newOrders = $user->isAdmin() ? \App\Models\Order::where('status', 'new')->count() : 0;
    $newRequests = $user->isAdmin() ? \App\Models\Project::where('status', 'new')->count() : 0;

    // Grouped navigation: section label => items.
    $groups = $user->isAdmin() ? [
        'الإدارة' => [
            ['route' => 'admin.dashboard', 'label' => 'لوحة التحكم', 'icon' => 'home'],
            ['route' => 'admin.clients', 'label' => 'العملاء', 'icon' => 'clients'],
        ],
        'الطلبات' => [
            ['route' => 'admin.requests', 'label' => 'طلبات التصميم', 'icon' => 'requests', 'badge' => $newRequests ?: null],
            ['route' => 'admin.orders', 'label' => 'طلبات المتجر', 'icon' => 'cart', 'badge' => $newOrders ?: null],
        ],
        'المتجر' => [
            ['route' => 'admin.products', 'label' => 'المنتجات', 'icon' => 'store'],
            ['route' => 'admin.categories', 'label' => 'الأقسام', 'icon' => 'projects'],
        ],
        'الحساب' => [
            ['route' => 'admin.settings', 'label' => 'الإعدادات', 'icon' => 'settings'],
        ],
    ] : [
        'مساحتي' => [
            ['route' => 'client.dashboard', 'label' => 'الرئيسية', 'icon' => 'home'],
            ['route' => 'client.projects.index', 'label' => 'مشاريعي', 'icon' => 'projects'],
        ],
        'التسوّق' => [
            ['route' => 'client.store', 'label' => 'متجر الأثاث', 'icon' => 'store'],
            ['route' => 'client.cart', 'label' => 'سلة المشتريات', 'icon' => 'cart', 'badge' => $cartCount ?: null],
            ['route' => 'client.orders', 'label' => 'طلباتي', 'icon' => 'requests'],
        ],
        'استكشاف' => [
            ['route' => 'client.portfolio', 'label' => 'معرض أعمالنا', 'icon' => 'portfolio'],
            ['route' => 'client.inspiration', 'label' => 'معرض الإلهام', 'icon' => 'inspiration'],
            ['route' => 'client.favorites', 'label' => 'مفضلتي', 'icon' => 'heart'],
            ['route' => 'client.about', 'label' => 'خدماتنا', 'icon' => 'about'],
        ],
        'الدعم' => [
            ['route' => 'client.chat', 'label' => 'الدردشة المباشرة', 'icon' => 'chat'],
            ['route' => 'client.settings', 'label' => 'الإعدادات', 'icon' => 'settings'],
        ],
    ];
@endphp

<aside data-sidebar
    class="group fixed lg:sticky right-0 lg:right-auto top-0 z-40 flex h-screen w-[276px] shrink-0 flex-col border-l border-line bg-[#FBF7F1] translate-x-full lg:translate-x-0">

    {{-- Brand + collapse toggle --}}
    <div class="flex items-center justify-between px-5 pb-4 pt-6 group-[.collapsed]:justify-center group-[.collapsed]:px-3">
        @include('partials.brand')
        <button data-sidebar-toggle class="lg:hidden text-muted" aria-label="إغلاق القائمة">
            @include('partials.icon', ['name' => 'arrow'])
        </button>
    </div>

    <div class="relative mx-5 border-t border-line/70 group-[.collapsed]:mx-3">
        {{-- Desktop collapse toggle sits on the divider --}}
        <button data-collapse-toggle aria-label="طي القائمة"
                class="absolute -top-3.5 left-0 hidden h-7 w-7 place-items-center rounded-full border border-line bg-white text-muted shadow-card transition hover:text-clay lg:grid">
            <svg class="h-3.5 w-3.5 transition-transform duration-300 group-[.collapsed]:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M13 6l6 6-6 6"/><path d="M5 6l6 6-6 6"/>
            </svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-4 pb-4 group-[.collapsed]:px-2.5">
        @foreach ($groups as $label => $items)
            <p class="nav-section group-[.collapsed]:hidden">{{ $label }}</p>
            <div class="my-1 hidden border-t border-line/60 first:hidden group-[.collapsed]:block"></div>
            <div class="space-y-1">
                @foreach ($items as $item)
                    @php $active = request()->routeIs($item['route']) || request()->routeIs($item['route'].'.*'); @endphp
                    <a href="{{ route($item['route']) }}" title="{{ $item['label'] }}"
                       class="nav-link {{ $active ? 'active' : '' }} group-[.collapsed]:justify-center group-[.collapsed]:px-0">
                        <span class="nav-ind"></span>
                        <span class="relative grid h-8 w-8 shrink-0 place-items-center rounded-lg {{ $active ? 'bg-clay-soft text-clay' : 'bg-white/70 text-ink/50' }} transition">
                            @include('partials.icon', ['name' => $item['icon'], 'class' => 'h-[18px] w-[18px]'])
                            @if (! empty($item['badge']))
                                <span class="absolute -left-1 -top-1 hidden h-2.5 w-2.5 rounded-full border-2 border-[#FBF7F1] bg-clay group-[.collapsed]:block"></span>
                            @endif
                        </span>
                        <span class="truncate group-[.collapsed]:hidden">{{ $item['label'] }}</span>
                        @if (! empty($item['badge']))
                            <span class="mr-auto grid h-5 min-w-5 place-items-center rounded-full bg-clay px-1.5 text-[11px] font-bold text-white group-[.collapsed]:hidden">{{ $item['badge'] }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        @endforeach
    </nav>

    {{-- Footer: WhatsApp + user --}}
    <div class="space-y-2.5 border-t border-line/70 px-4 py-4 group-[.collapsed]:px-2.5">
        <a href="https://wa.me/966500000000" target="_blank" rel="noopener" title="تواصل عبر واتساب"
           class="flex items-center gap-3 rounded-2xl bg-pine px-4 py-3 text-sm text-white transition hover:bg-pine/90 group-[.collapsed]:justify-center group-[.collapsed]:px-0 group-[.collapsed]:py-2.5">
            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-white/15">
                @include('partials.icon', ['name' => 'chat', 'class' => 'h-4 w-4'])
            </span>
            <span class="leading-tight group-[.collapsed]:hidden">
                <b class="block">تواصل عبر واتساب</b>
                <small class="text-white/70">فريق سارا جاهز لك</small>
            </span>
        </a>

        <div class="flex items-center gap-3 rounded-2xl border border-line bg-white px-3.5 py-3 group-[.collapsed]:justify-center group-[.collapsed]:border-0 group-[.collapsed]:bg-transparent group-[.collapsed]:px-0 group-[.collapsed]:py-0">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-clay-soft font-bold text-clay" title="{{ $user->name }}">
                {{ $user->initials() }}
            </span>
            <span class="min-w-0 flex-1 leading-tight group-[.collapsed]:hidden">
                <b class="block truncate text-sm text-ink">{{ $user->name }}</b>
                <small class="text-muted">{{ $user->isAdmin() ? 'حساب مشرف' : 'حساب عميل' }}</small>
            </span>
            <form method="POST" action="{{ route('logout') }}" class="group-[.collapsed]:hidden">
                @csrf
                <button class="grid h-9 w-9 place-items-center rounded-xl text-muted transition hover:bg-clay-soft hover:text-clay" aria-label="تسجيل الخروج">
                    @include('partials.icon', ['name' => 'logout', 'class' => 'h-[18px] w-[18px]'])
                </button>
            </form>
        </div>
    </div>
</aside>

<script>
    (function () {
        var aside = document.querySelector('[data-sidebar]');
        if (!aside) return;
        try {
            if (localStorage.getItem('seraSidebar') === 'min') aside.classList.add('collapsed');
        } catch (e) {}
        var btn = aside.querySelector('[data-collapse-toggle]');
        if (btn) btn.addEventListener('click', function () {
            aside.classList.toggle('collapsed');
            try {
                localStorage.setItem('seraSidebar', aside.classList.contains('collapsed') ? 'min' : 'full');
            } catch (e) {}
        });
    })();
</script>
