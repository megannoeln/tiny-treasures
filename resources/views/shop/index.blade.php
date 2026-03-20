@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <div class="flex items-end justify-between gap-4">
        <div>
            <h1 class="font-serif text-[1.7rem] font-semibold tracking-wide">Shop</h1>
            <p class="mt-2 text-sm text-zinc-400">Items currently available. No checkout — just request to purchase.</p>
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($items as $item)
            <a href="{{ route('shop.show', $item) }}" class="card card-hover group overflow-hidden no-underline">
                <div class="relative aspect-[4/3] overflow-hidden bg-zinc-950">
                    @if ($item->image_path)
                        <img class="h-full w-full object-cover transition group-hover:scale-[1.02]" src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->title }}">
                    @else
                        <div class="flex h-full items-center justify-center text-sm text-zinc-500">No image</div>
                    @endif

                    @if ($item->is_sold)
                        <div class="absolute inset-0 flex items-center justify-center bg-stone-950/60">
                            <div class="rounded-xl border border-stone-700 bg-stone-950/80 px-5 py-3 text-sm font-semibold tracking-wide text-stone-100">
                                Sold
                            </div>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="font-medium">{{ $item->title }}</div>
                            <div class="mt-1 text-sm text-zinc-400">
                                @if ($item->price_cents !== null)
                                    ${{ number_format($item->price_cents / 100, 2) }}
                                @else
                                    Price on request
                                @endif
                            </div>
                        </div>
                        @if ($item->is_sold)
                            <div class="text-sm font-semibold text-stone-400">Sold</div>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="text-sm text-zinc-500">No items for sale yet.</div>
        @endforelse
    </div>

    <div class="mt-8">{{ $items->links() }}</div>
@endsection
