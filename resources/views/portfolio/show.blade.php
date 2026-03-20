@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    @php
        $showDescription = filled($artwork->description);
    @endphp

    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-[1.7rem] font-semibold tracking-wide">{{ $artwork->title }}</h1>
            <p class="mt-2 text-sm text-zinc-400">
                @if ($artwork->year) {{ $artwork->year }} @endif
            </p>
        </div>
        <a href="{{ route('portfolio.index') }}" class="text-sm text-zinc-300 hover:text-[#5a3f66]">Back</a>
    </div>

    <div class="mt-8 grid gap-8 lg:grid-cols-12">
        <div class="{{ $showDescription ? 'lg:col-span-7' : 'lg:col-span-12' }}">
            <div class="card overflow-hidden">
                <div class="bg-zinc-950 p-3 sm:p-4">
                    @if ($artwork->image_path)
                        <img class="mx-auto max-h-[75vh] w-full object-contain" src="{{ asset('storage/'.$artwork->image_path) }}" alt="{{ $artwork->title }}">
                    @else
                        <div class="flex h-64 items-center justify-center text-sm text-zinc-500">No image</div>
                    @endif
                </div>
            </div>
        </div>

        @if ($showDescription)
            <div class="lg:col-span-5">
                <div class="card p-6">
                    <h2 class="text-lg font-semibold">Details</h2>
                    <div class="mt-4 whitespace-pre-wrap text-sm leading-relaxed text-zinc-300">{{ $artwork->description }}</div>
                </div>
            </div>
        @endif
    </div>
@endsection
