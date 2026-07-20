@extends('layouts.app')
@section('title', 'طلبات المتجر')
@section('heading', 'طلبات المتجر')

@section('content')
    <h1 class="font-display text-3xl">طلبات المتجر</h1>
    <p class="mt-1 text-muted">{{ $orders->count() }} طلباً — حدّث الحالة ليصل التغيير للعميل مباشرة.</p>

    @if ($orders->isEmpty())
        <div class="card mt-6 p-10 text-center text-muted">لا توجد طلبات بعد.</div>
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
                        <div class="flex items-center gap-3">
                            <span class="grid h-10 w-10 place-items-center rounded-full bg-ink text-sm font-bold text-white">#{{ $order->id }}</span>
                            <div>
                                <b class="text-ink">{{ $order->user->name }}</b>
                                <p class="text-xs text-muted">{{ $order->created_at->format('Y/m/d — H:i') }} · {{ $order->items->sum('qty') }} قطعة</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="pill {{ $badge }}">{{ $order->statusLabel() }}</span>
                            <span class="font-bold text-clay">{{ number_format($order->total) }} ريال</span>
                            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <select name="status" class="field !w-36 text-sm" onchange="this.form.submit()">
                                    <option value="new" @selected($order->status === 'new')>جديد</option>
                                    <option value="preparing" @selected($order->status === 'preparing')>قيد التجهيز</option>
                                    <option value="delivered" @selected($order->status === 'delivered')>تم التوصيل</option>
                                    <option value="cancelled" @selected($order->status === 'cancelled')>ملغي</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <ul class="mt-4 divide-y divide-line border-t border-line text-sm">
                        @foreach ($order->items as $item)
                            <li class="flex items-center justify-between py-2">
                                <span>{{ $item->name }} <span class="text-muted">× {{ $item->qty }}</span></span>
                                <span class="font-bold">{{ number_format($item->price * $item->qty) }} ريال</span>
                            </li>
                        @endforeach
                    </ul>
                    @if ($order->note)
                        <p class="mt-3 rounded-xl bg-sand px-4 py-2 text-sm">ملاحظة العميل: {{ $order->note }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection
