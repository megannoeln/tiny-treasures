@extends('layouts.app')

@section('title', $item->title.' · Shop · '.config('app.name'))

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-wide">{{ $item->title }}</h1>
            <p class="mt-2 text-sm text-zinc-400">
                @if ($item->price_cents !== null)
                    ${{ number_format($item->price_cents / 100, 2) }}
                @else
                    Price on request
                @endif
            </p>
        </div>
        <a href="{{ route('shop.index') }}" class="btn btn-secondary no-underline">Back</a>
    </div>

    <div class="mt-8 grid gap-8 lg:grid-cols-12">
        <div class="lg:col-span-7">
            <div class="card overflow-hidden">
                <div class="bg-zinc-950 p-3 sm:p-4">
                    @if ($item->image_path)
                        <div class="relative">
                            <img class="mx-auto max-h-[75vh] w-full object-contain" src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->title }}">
                            @if ($item->is_sold)
                                <div class="absolute inset-0 flex items-center justify-center bg-stone-950/55">
                                    <div class="rounded-xl border border-stone-700 bg-stone-950/80 px-5 py-3 text-sm font-semibold tracking-wide text-stone-100">
                                        Sold
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="flex h-64 items-center justify-center text-sm text-zinc-500">No image</div>
                    @endif
                </div>
            </div>

            @if ($item->description)
                <div class="mt-6 whitespace-pre-wrap text-sm leading-relaxed text-zinc-300">{{ $item->description }}</div>
            @endif
        </div>

        <div class="lg:col-span-5">
            <div class="card p-6">
                @if ($item->is_sold)
                    <h2 class="text-lg font-semibold">Sold</h2>
                    <p class="mt-2 text-sm text-zinc-400">This item has been marked as sold.</p>
                @else
                    <h2 class="text-lg font-semibold">Request to purchase</h2>
                    <p class="mt-2 text-sm text-zinc-400">We’ll confirm availability and send details by email.</p>

                    <form class="mt-5 space-y-4" method="POST" action="{{ route('shop.request', $item) }}">
                        @csrf
                        <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off" />

                        <div>
                            <label class="label" for="email">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="field mt-1" />
                            @error('email')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="label" for="name">Name (optional)</label>
                            <input id="name" name="name" value="{{ old('name') }}" class="field mt-1" />
                            @error('name')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="label" for="message">Message (optional)</label>
                            <textarea id="message" name="message" rows="5" class="field mt-1">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-full">Request to purchase</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
