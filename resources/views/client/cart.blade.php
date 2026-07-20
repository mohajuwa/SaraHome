@extends('layouts.app')
@section('title', 'سلة المشتريات')
@section('heading', 'سلة المشتريات')

@section('content')
    <h1 class="font-display text-3xl">سلة المشتريات</h1>

    @if ($items->isEmpty())
        <div class="card mt-6 flex flex-col items-center gap-3 p-10 text-center">
            <span class="grid h-14 w-14 place-items-center rounded-2xl bg-clay-soft text-clay">
                @include('partials.icon', ['name' => 'cart', 'class' => 'h-7 w-7'])
            </span>
            <h2 class="font-display text-xl">سلتك فارغة</h2>
            <p class="max-w-sm text-sm text-muted">تصفّحي المتجر وأضيفي القطع اللي تعجبك.</p>
            <a href="{{ route('client.store') }}" class="btn-primary mt-2">زيارة المتجر</a>
        </div>
    @else
        <div class="mt-6 grid gap-6 lg:grid-cols-[1.5fr,1fr]">
            <div class="card divide-y divide-line">
                @foreach ($items as $item)
                    <div class="flex items-center gap-4 p-4">
                        <div class="h-20 w-24 shrink-0 overflow-hidden rounded-xl bg-sand">
                            <img src="{{ $item['product']->imageUrl() }}" alt="{{ $item['product']->name }}" class="h-full w-full object-cover">
                        </div>
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('client.store.show', $item['product']) }}" class="font-bold text-ink hover:text-clay">{{ $item['product']->name }}</a>
                            <p class="text-sm text-muted">{{ number_format($item['product']->price) }} ريال للقطعة</p>
                        </div>
                        <form method="POST" action="{{ route('client.cart.update') }}" class="flex items-center gap-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                            <input type="number" name="qty" value="{{ $item['qty'] }}" min="0" max="99"
                                   class="field w-20 text-center" onchange="this.form.submit()">
                        </form>
                        <span class="w-24 whitespace-nowrap text-end font-bold text-ink">{{ number_format($item['product']->price * $item['qty']) }} ريال</span>
                        <form method="POST" action="{{ route('client.cart.update') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                            <input type="hidden" name="qty" value="0">
                            <button class="text-muted transition hover:text-clay" aria-label="حذف">×</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="card h-fit p-6">
                <h2 class="font-display text-xl">ملخص الطلب</h2>
                <div class="mt-4 flex items-center justify-between border-b border-line pb-4">
                    <span class="text-muted">الإجمالي</span>
                    <span class="text-2xl font-bold text-clay">{{ number_format($total) }} <span class="text-sm text-muted">ريال</span></span>
                </div>
                <form method="POST" action="{{ route('client.cart.checkout') }}" class="mt-4 space-y-3">
                    @csrf
                    <div>
                        <label class="mb-1 block text-sm font-bold">ملاحظات (اختياري)</label>
                        <textarea name="note" rows="3" maxlength="500" class="field" placeholder="مثال: التوصيل مساءً"></textarea>
                    </div>
                    <button class="btn-primary w-full" data-busy-text="جارٍ إرسال الطلب…">إرسال الطلب</button>
                    <p class="text-center text-xs text-muted">سيتواصل معك فريق سارا لتأكيد التفاصيل والدفع.</p>
                </form>
            </div>
        </div>
    @endif
@endsection
