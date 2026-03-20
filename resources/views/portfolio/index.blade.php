@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    <div class="flex items-end justify-between gap-4">
        <div>
            <h1 class="font-serif text-[1.7rem] font-semibold tracking-wide">Portfolio</h1>
            <p class="mt-2 text-sm text-zinc-400">Custom work and past pieces.</p>
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($artworks as $artwork)
            <a href="{{ route('portfolio.show', $artwork) }}" class="card card-hover group overflow-hidden no-underline">
                <div class="aspect-[4/3] overflow-hidden bg-zinc-950">
                    @if ($artwork->image_path)
                        <img class="h-full w-full object-cover transition group-hover:scale-[1.02]" src="{{ asset('storage/'.$artwork->image_path) }}" alt="{{ $artwork->title }}">
                    @else
                        <div class="flex h-full items-center justify-center text-sm text-zinc-500">No image</div>
                    @endif
                </div>
                <div class="p-4">
                    <div class="font-medium">{{ $artwork->title }}</div>
                    @if ($artwork->year)
                        <div class="text-sm text-zinc-400">{{ $artwork->year }}</div>
                    @endif
                </div>
            </a>
        @empty
            <div class="text-zinc-400">No portfolio items yet.</div>
        @endforelse
    </div>

    <div class="mt-8">{{ $artworks->links() }}</div>
@endsection
