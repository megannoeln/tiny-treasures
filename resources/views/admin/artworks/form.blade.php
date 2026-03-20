@extends('layouts.admin')

@section('title', $artwork->exists ? 'Edit Artwork' : 'New Artwork')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-[1.4rem] font-semibold tracking-wide">
                {{ $artwork->exists ? 'Edit Artwork' : 'New Artwork' }}
            </h1>
            <p class="mt-1 text-sm text-zinc-400">Used for the public portfolio.</p>
        </div>
        <a href="{{ route('admin.artworks.index') }}" class="text-sm text-zinc-300 hover:text-[#5a3f66]">Back</a>
    </div>

    <form class="mt-6 space-y-6 rounded-xl border border-zinc-800 bg-zinc-900/30 p-6"
        method="POST"
        enctype="multipart/form-data"
        action="{{ $artwork->exists ? route('admin.artworks.update', $artwork) : route('admin.artworks.store') }}">
        @csrf
        @if ($artwork->exists)
            @method('PUT')
        @endif

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="title">Title</label>
                <input id="title" name="title" value="{{ old('title', $artwork->title) }}" required
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-[#8c733b] focus:ring-2" />
                @error('title')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm text-zinc-300" for="slug">Slug (optional)</label>
                <input id="slug" name="slug" value="{{ old('slug', $artwork->slug) }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-[#8c733b] focus:ring-2" />
                @error('slug')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm text-zinc-300" for="year">Year (optional)</label>
                <input id="year" name="year" type="number" value="{{ old('year', $artwork->year) }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-[#8c733b] focus:ring-2" />
                @error('year')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm text-zinc-300" for="sort_order">Sort Order</label>
                <input id="sort_order" name="sort_order" type="number" value="{{ old('sort_order', $artwork->sort_order ?? 0) }}"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-[#8c733b] focus:ring-2" />
                @error('sort_order')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <div class="flex flex-wrap items-center gap-4">
                    <label class="flex items-center gap-2 text-sm text-zinc-300">
                        <input type="checkbox" name="is_for_sale" value="1" {{ old('is_for_sale', (bool) $artwork->is_for_sale) ? 'checked' : '' }}
                            class="rounded border-zinc-700 bg-zinc-950">
                        For sale
                    </label>

                    <label class="flex items-center gap-2 text-sm text-zinc-300">
                        <input type="checkbox" name="is_sold" value="1" {{ old('is_sold', (bool) $artwork->is_sold) ? 'checked' : '' }}
                            class="rounded border-zinc-700 bg-zinc-950">
                        Mark sold
                    </label>

                    <div class="flex items-center gap-2">
                        <label class="text-sm text-zinc-300" for="price">Price (optional)</label>
                        <input id="price" name="price" type="number" step="0.01" min="0"
                            value="{{ old('price', $artwork->price_cents !== null ? number_format($artwork->price_cents / 100, 2, '.', '') : '') }}"
                            class="rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-[#8c733b] focus:ring-2" />
                    </div>
                </div>
                @error('price')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="text-sm text-zinc-300" for="description">Description (optional)</label>
                <textarea id="description" name="description" rows="5"
                    class="mt-1 w-full rounded-md border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm outline-none ring-[#8c733b] focus:ring-2">{{ old('description', $artwork->description) }}</textarea>
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
                <div class="flex flex-wrap items-center gap-4">
                    <p class="text-sm text-zinc-400">Items appear on the site as soon as they’re created.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button class="rounded-md bg-[#7a6230] px-4 py-2 text-sm font-semibold text-[#f5ecd3] hover:bg-[#8c733b]" type="submit">
                Save
            </button>
        </div>
    </form>
@endsection
