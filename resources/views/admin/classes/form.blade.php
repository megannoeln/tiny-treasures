@extends('layouts.admin')

@section('title', $classListing->exists ? 'Edit Class' : 'New Class')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">
                {{ $classListing->exists ? 'Edit Class' : 'New Class' }}
            </h1>
            <p class="mt-1 text-sm text-zinc-400">Class details, capacity, and optional price.</p>
        </div>
        <a href="{{ route('admin.classes.index') }}" class="text-sm text-zinc-300 hover:text-white">Back</a>
    </div>

    <form class="mt-6 space-y-6 rounded-xl border border-zinc-800 bg-zinc-900/30 p-6"
        method="POST"
        enctype="multipart/form-data"
        action="{{ $classListing->exists ? route('admin.classes.update', $classListing) : route('admin.classes.store') }}">
        @csrf
        @if ($classListing->exists)
            @method('PUT')
        @endif

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="title">Title</label>
                <input id="title" name="title" value="{{ old('title', $classListing->title) }}" required
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2" />
                @error('title')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm text-zinc-300" for="starts_at">Starts</label>
                <input id="starts_at" name="starts_at" type="datetime-local"
                    value="{{ old('starts_at', $classListing->starts_at?->format('Y-m-d\\TH:i')) }}" required
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2" />
                @error('starts_at')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm text-zinc-300" for="capacity">Capacity (optional)</label>
                <input id="capacity" name="capacity" type="number" value="{{ old('capacity', $classListing->capacity) }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2" />
                @error('capacity')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-end">
                <label class="flex items-center gap-2 text-sm text-zinc-300">
                    <input type="checkbox" name="sold_out" value="1" {{ old('sold_out', (bool) $classListing->sold_out) ? 'checked' : '' }}
                        class="rounded border-zinc-700 bg-zinc-950">
                    Sold out
                </label>
            </div>

            <div>
                <label class="text-sm text-zinc-300" for="location">Location (optional)</label>
                <input id="location" name="location" value="{{ old('location', $classListing->location) }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2" />
                @error('location')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="price">Price (optional)</label>
                <input id="price" name="price" type="number" step="0.01" min="0"
                    value="{{ old('price', $classListing->price !== null ? number_format((float) $classListing->price, 2, '.', '') : '') }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2" />
                @error('price')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="deposit">Deposit (optional)</label>
                <input id="deposit" name="deposit" type="number" step="0.01" min="0"
                    value="{{ old('deposit', $classListing->deposit !== null ? number_format((float) $classListing->deposit, 2, '.', '') : '') }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2" />
                @error('deposit')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="charity_link">Charity Link (optional)</label>
                <input id="charity_link" name="charity_link" type="url" value="{{ old('charity_link', $classListing->charity_link) }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2" />
                @error('charity_link')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="description">Description (optional)</label>
                <textarea id="description" name="description" rows="6"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2">{{ old('description', $classListing->description) }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="flyer">Flyer (optional)</label>
                <input id="flyer" name="flyer" type="file" accept="image/*"
                    class="mt-1 block w-full text-sm text-zinc-300 file:mr-4 file:rounded-md file:border-0 file:bg-zinc-800 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-zinc-700" />
                @error('flyer')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror

                @if ($classListing->flyer_path)
                    <div class="mt-4 flex items-center gap-4">
                        <img class="h-20 w-20 rounded-lg object-cover" src="{{ asset('storage/'.$classListing->flyer_path) }}" alt="" />
                        <label class="flex items-center gap-2 text-sm text-zinc-300">
                            <input type="checkbox" name="remove_flyer" value="1" class="rounded border-zinc-700 bg-zinc-950">
                            Remove flyer
                        </label>
                    </div>
                @endif
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <button class="rounded-md bg-emerald-500 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-emerald-400" type="submit">
                Save
            </button>
        </div>
    </form>
@endsection
