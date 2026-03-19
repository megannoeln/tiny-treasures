@extends('layouts.admin')

@section('title', $artwork->exists ? 'Edit Portfolio Item' : 'New Portfolio Item')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">
                {{ $artwork->exists ? 'Edit Portfolio Item' : 'New Portfolio Item' }}
            </h1>
            <p class="mt-1 text-sm text-zinc-400">These items never appear in the Shop.</p>
        </div>
        <a href="{{ route('admin.portfolio.index') }}" class="text-sm text-zinc-300 hover:text-white">Back</a>
    </div>

    <form class="mt-6 space-y-6 rounded-xl border border-zinc-800 bg-zinc-900/30 p-6"
        method="POST"
        enctype="multipart/form-data"
        action="{{ $artwork->exists ? route('admin.portfolio.update', $artwork) : route('admin.portfolio.store') }}">
        @csrf
        @if ($artwork->exists)
            @method('PUT')
        @endif

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="title">Title</label>
                <input id="title" name="title" value="{{ old('title', $artwork->title) }}" required
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2" />
                @error('title')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="description">Description (optional)</label>
                <textarea id="description" name="description" rows="6"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2">{{ old('description', $artwork->description) }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="image">Image (optional)</label>
                <input id="image" name="image" type="file" accept="image/*"
                    class="mt-1 block w-full text-sm text-zinc-300 file:mr-4 file:rounded-md file:border-0 file:bg-zinc-800 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-zinc-700" />
                @error('image')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror

                @if ($artwork->image_path)
                    <div class="mt-4 flex items-center gap-4">
                        <img class="h-20 w-20 rounded-lg object-cover" src="{{ asset('storage/'.$artwork->image_path) }}" alt="" />
                        <label class="flex items-center gap-2 text-sm text-zinc-300">
                            <input type="checkbox" name="remove_image" value="1" class="rounded border-zinc-700 bg-zinc-950">
                            Remove image
                        </label>
                    </div>
                @endif
            </div>

            <div class="sm:col-span-2">
                <p class="text-sm text-zinc-400">Portfolio items are saved as “not for sale”.</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button class="rounded-md bg-emerald-500 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-emerald-400" type="submit">
                Save
            </button>
        </div>
    </form>
@endsection
