@extends('layouts.admin')

@section('title', 'Portfolio')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Portfolio</h1>
            <p class="mt-1 text-sm text-zinc-400">Artwork items that are not for sale.</p>
        </div>
        <a href="{{ route('admin.portfolio.create') }}" class="rounded-md bg-emerald-500 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-emerald-400">New</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-zinc-800">
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-900/40 text-zinc-300">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Image</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse ($artworks as $artwork)
                    <tr class="bg-zinc-950/40">
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $artwork->title }}</div>
                        </td>
                        <td class="px-4 py-3 text-zinc-300">
                            @if ($artwork->description)
                                {{ str($artwork->description)->limit(140) }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-zinc-300">
                            @if ($artwork->image_path)
                                <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/'.$artwork->image_path) }}" alt="" />
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a class="rounded-md border border-zinc-800 px-3 py-1.5 hover:border-zinc-700" href="{{ route('admin.portfolio.edit', $artwork) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.portfolio.destroy', $artwork) }}" onsubmit="return confirm('Delete this portfolio item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-md border border-red-900/60 px-3 py-1.5 text-red-200 hover:border-red-800" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-zinc-400" colspan="4">No portfolio items yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $artworks->links() }}</div>
@endsection
