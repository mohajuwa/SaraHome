@extends('layouts.app')
@section('title', 'إعدادات المشرف')
@section('heading', 'الإعدادات')

@section('content')
    <div class="max-w-2xl">
        <p class="text-xs font-bold tracking-[.2em] text-clay">إدارة المنصة</p>
        <h1 class="mt-1 font-display text-3xl">إعدادات المشرف</h1>

        <div class="card mt-6 divide-y divide-line">
            @foreach ([['إشعارات الطلبات الجديدة', true], ['ملخص أسبوعي للنشاط', true], ['السماح بالتسجيل الذاتي للعملاء', false]] as [$label, $on])
                <label class="flex cursor-pointer items-center justify-between p-5">
                    <span class="font-bold text-ink">{{ $label }}</span>
                    <span class="relative inline-flex h-6 w-11 items-center rounded-full {{ $on ? 'bg-clay' : 'bg-line' }}">
                        <input type="checkbox" class="peer sr-only" @checked($on)>
                        <span class="absolute {{ $on ? 'left-1' : 'right-1' }} h-4 w-4 rounded-full bg-white"></span>
                    </span>
                </label>
            @endforeach
        </div>
    </div>
@endsection
