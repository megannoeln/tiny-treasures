@extends('layouts.admin')

@section('title', 'Inquiry')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Inquiry</h1>
            <p class="mt-1 text-sm text-zinc-400">{{ ucfirst($inquiry->type) }} · {{ $inquiry->created_at?->format('Y-m-d H:i') }}</p>
        </div>
        <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-zinc-300 hover:text-white">Back</a>
    </div>

    <div class="mt-6 rounded-xl border border-zinc-800 bg-zinc-900/30 p-6">
        @if ($inquiry->artwork)
            <div class="mb-6">
                <div class="text-sm text-zinc-400">Item</div>
                <div class="mt-1 font-semibold">{{ $inquiry->artwork->title }}</div>
                <div class="mt-2">
                    <a class="underline decoration-zinc-600 underline-offset-2 hover:decoration-zinc-300" href="{{ $inquiry->artwork->is_for_sale ? route('admin.shop.edit', $inquiry->artwork) : route('admin.portfolio.edit', $inquiry->artwork) }}">
                        Open in admin
                    </a>
                </div>
            </div>
        @endif

        <div class="text-sm text-zinc-400">From</div>
        <div class="mt-1 font-semibold">{{ $inquiry->name ?: '—' }}</div>
        <div class="text-sm text-zinc-300">{{ $inquiry->email }}</div>

        <div class="mt-6 text-sm text-zinc-400">Message</div>
        <div class="mt-2 whitespace-pre-wrap text-sm leading-relaxed text-zinc-100">{{ $inquiry->message }}</div>
    </div>
@endsection
