@extends('layouts.app')
@section('title', 'طلباتي')
@section('heading', 'طلباتي')

@section('content')
    <h1 class="font-display text-3xl">طلباتي</h1>

    @if ($orders->isEmpty())
        <div class="card mt-6 flex flex-col items-center gap-3 p-10 text-center">
            <h2 class="font-display text-xl">لا توجد طلبات بعد</h2>
            <p class="max-w-sm text-sm text-muted">أضيفي قطعاً من المتجر ثم أرسلي طلبك.</p>
            <a href="{{ route('client.store') }}" class="btn-primary mt-2">زيارة المتجر</a>
        </div>
    @else
        <div class="mt-6 space-y-4">
            @foreach ($orders as $order)
                @php
                    $badge = [
                        'new' => 'bg-ochre-soft text-ochre',
                        'preparing' => 'bg-clay-soft text-clay',
                        'delivered' => 'bg-pine-soft text-pine',
                        'cancelled' => 'bg-sand text-muted',
                    ][$order->status] ?? 'bg-sand text-ink';
                @endphp
                <div class="card p-5">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="font-bold text-ink">طلب #{{ $order->id }}</p>
                            <p class="text-xs text-muted">{{ $order->created_at->format('Y/m/d — H:i') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="pill {{ $badge }}">{{ $order->statusLabel() }}</span>
                            <span class="font-bold text-clay">{{ number_format($order->total) }} ريال</span>
                        </div>
                    </div>
                    <ul class="mt-4 divide-y divide-line border-t border-line">
                        @foreach ($order->items as $item)
                            <li class="flex items-center justify-between py-2 text-sm">
                                <span class="text-ink">{{ $item->name }} <span class="text-muted">× {{ $item->qty }}</span></span>
                                <span class="font-bold">{{ number_format($item->price * $item->qty) }} ريال</span>
                            </li>
                        @endforeach
                    </ul>
                    @if ($order->note)
                        <p class="mt-3 rounded-xl bg-sand px-4 py-2 text-sm text-ink/80">ملاحظتك: {{ $order->note }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection
