@extends('layouts.admin')

@section('title', $item->exists ? 'Edit Shop Item' : 'New Shop Item')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-[1.4rem] font-semibold tracking-wide">
                {{ $item->exists ? 'Edit Shop Item' : 'New Shop Item' }}
            </h1>
            <p class="mt-1 text-sm text-zinc-400">These items appear on the public Shop page.</p>
        </div>
        <a href="{{ route('admin.shop.index') }}" class="text-sm text-zinc-300 hover:text-[#5a3f66]">Back</a>
    </div>

    <form class="mt-6 space-y-6 rounded-xl border border-zinc-800 bg-zinc-900/30 p-6"
        method="POST"
        enctype="multipart/form-data"
        action="{{ $item->exists ? route('admin.shop.update', $item) : route('admin.shop.store') }}">
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="title">Title</label>
                <input id="title" name="title" value="{{ old('title', $item->title) }}" required
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-amber-400 focus:ring-2" />
                @error('title')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="price">Price (optional)</label>
                <input id="price" name="price" type="number" step="0.01" min="0"
                    value="{{ old('price', $item->price_cents !== null ? number_format($item->price_cents / 100, 2, '.', '') : '') }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-amber-400 focus:ring-2" />
                @error('price')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-end">
                <label class="flex items-center gap-2 text-sm text-zinc-300">
                    <input type="checkbox" name="is_sold" value="1" {{ old('is_sold', (bool) $item->is_sold) ? 'checked' : '' }}
                        class="rounded border-zinc-700 bg-zinc-950">
                    Sold
                </label>
            </div>

            <div class="flex items-end">
                <label class="flex items-center gap-2 text-sm text-zinc-300">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', (bool) $item->is_featured) ? 'checked' : '' }}
                        class="rounded border-zinc-700 bg-zinc-950">
                    Featured
                </label>
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="description">Description (optional)</label>
                <textarea id="description" name="description" rows="6"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-amber-400 focus:ring-2">{{ old('description', $item->description) }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="image">Image (optional)</label>
                <input id="image" name="image" type="file" accept="image/*"
                    class="mt-1 block w-full text-sm text-zinc-300 file:mr-4 file:rounded-md file:border-0 file:bg-zinc-800 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-zinc-700" />
                @error('image')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror

                @if ($item->image_path)
                    <div class="mt-4 flex items-center gap-4">
                        <img class="h-20 w-20 rounded-lg object-cover" src="{{ asset('storage/'.$item->image_path) }}" alt="" />
                        <label class="flex items-center gap-2 text-sm text-zinc-300">
                            <input type="checkbox" name="remove_image" value="1" class="rounded border-zinc-700 bg-zinc-950">
                            Remove image
                        </label>
                    </div>
                @endif
            </div>

            <div class="sm:col-span-2">
                <p class="text-sm text-zinc-400">Shop items are saved as “for sale”.</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button class="rounded-md bg-rose-700 px-4 py-2 text-sm font-semibold text-stone-50 hover:bg-rose-600" type="submit">
                Save
            </button>
        </div>
    </form>
@endsection
