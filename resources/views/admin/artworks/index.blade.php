@extends('layouts.admin')

@section('title', 'Artworks')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-[1.4rem] font-semibold tracking-wide">Artwork</h1>
            <p class="mt-1 text-sm text-zinc-400">Portfolio items.</p>
        </div>
        <a href="{{ route('admin.artworks.create') }}" class="rounded-md bg-[#7a6230] px-4 py-2 text-sm font-semibold text-[#f5ecd3] hover:bg-[#8c733b]">New</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-zinc-800">
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-900/40 text-zinc-300">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">For Sale</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Order</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse ($artworks as $artwork)
                    <tr class="bg-zinc-950/40">
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $artwork->title }}</div>
                            <div class="text-xs text-zinc-400">{{ $artwork->slug }}</div>
                        </td>
                        <td class="px-4 py-3 text-zinc-300">
                            {{ $artwork->is_for_sale ? ($artwork->is_sold ? 'Sold' : 'Yes') : 'No' }}
                        </td>
                        <td class="px-4 py-3 text-zinc-300">
                            @if ($artwork->price_cents !== null)
                                ${{ number_format($artwork->price_cents / 100, 2) }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-zinc-300">{{ $artwork->sort_order }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a class="rounded-md border border-zinc-800 px-3 py-1.5 hover:border-zinc-700" href="{{ route('admin.artworks.edit', $artwork) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.artworks.destroy', $artwork) }}" onsubmit="return confirm('Delete this artwork?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-md border border-red-900/60 px-3 py-1.5 text-red-200 hover:border-red-800" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-zinc-400" colspan="5">No artworks yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $artworks->links() }}</div>
@endsection
