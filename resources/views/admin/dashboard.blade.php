@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="flex flex-col gap-6">
        <div>
            <h1 class="font-serif text-[1.4rem] font-semibold tracking-wide">Dashboard</h1>
            <p class="mt-1 text-sm text-zinc-400">Quick links to manage your content.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <a href="{{ route('admin.portfolio.index') }}" class="rounded-xl border border-zinc-800 bg-zinc-900/30 p-4 hover:border-zinc-700">
                <div class="font-semibold">Portfolio</div>
            </a>
            <a href="{{ route('admin.events.index') }}" class="rounded-xl border border-zinc-800 bg-zinc-900/30 p-4 hover:border-zinc-700">
                <div class="font-semibold">Events</div>
            </a>
            <a href="{{ route('admin.classes.index') }}" class="rounded-xl border border-zinc-800 bg-zinc-900/30 p-4 hover:border-zinc-700">
                <div class="font-semibold">Classes</div>
            </a>
            <a href="{{ route('admin.inquiries.index') }}" class="rounded-xl border border-zinc-800 bg-zinc-900/30 p-4 hover:border-zinc-700">
                <div class="font-semibold">Inquiries</div>
            </a>
            <a href="{{ route('admin.shop.index') }}" class="rounded-xl border border-zinc-800 bg-zinc-900/30 p-4 hover:border-zinc-700">
                <div class="font-semibold">Shop</div>
            </a>
        </div>
    </div>
@endsection
