@extends('layouts.admin')

@section('title', $event->exists ? 'Edit Event' : 'New Event')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-[1.4rem] font-semibold tracking-wide">
                {{ $event->exists ? 'Edit Event' : 'New Event' }}
            </h1>
            <p class="mt-1 text-sm text-zinc-400">Markets, pop-ups, and appearances.</p>
        </div>
        <a href="{{ route('admin.events.index') }}" class="text-sm text-zinc-300 hover:text-[#5a3f66]">Back</a>
    </div>

    <form class="mt-6 space-y-6 rounded-xl border border-zinc-800 bg-zinc-900/30 p-6"
        method="POST"
        action="{{ $event->exists ? route('admin.events.update', $event) : route('admin.events.store') }}">
        @csrf
        @if ($event->exists)
            @method('PUT')
        @endif

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="name">Name</label>
                <input id="name" name="name" value="{{ old('name', $event->name) }}" required
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-[#8c733b] focus:ring-2" />
                @error('name')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm text-zinc-300" for="starts_at">Starts</label>
                <input id="starts_at" name="starts_at" type="datetime-local"
                    value="{{ old('starts_at', $event->starts_at?->format('Y-m-d\\TH:i')) }}" required
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-[#8c733b] focus:ring-2" />
                @error('starts_at')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm text-zinc-300" for="ends_at">Ends (optional)</label>
                <input id="ends_at" name="ends_at" type="datetime-local"
                    value="{{ old('ends_at', $event->ends_at?->format('Y-m-d\\TH:i')) }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-[#8c733b] focus:ring-2" />
                @error('ends_at')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="location">Location (optional)</label>
                <input id="location" name="location" value="{{ old('location', $event->location) }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-[#8c733b] focus:ring-2" />
                @error('location')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="external_link">External Link (optional)</label>
                <input id="external_link" name="external_link" value="{{ old('external_link', $event->external_link) }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-[#8c733b] focus:ring-2" />
                @error('external_link')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button class="rounded-md bg-[#7a6230] px-4 py-2 text-sm font-semibold text-[#f5ecd3] hover:bg-[#8c733b]" type="submit">
                Save
            </button>
        </div>
    </form>
@endsection
