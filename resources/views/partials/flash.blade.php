@if (session('status'))
    <div data-toast
        class="fixed bottom-6 left-1/2 z-50 -translate-x-1/2 rounded-full bg-ink px-6 py-3 text-sm font-bold text-white shadow-soft transition-all duration-500">
        {{ session('status') }}
    </div>
@endif
