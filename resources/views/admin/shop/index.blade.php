@extends('layouts.admin')

@section('title', 'Shop')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Shop</h1>
            <p class="mt-1 text-sm text-zinc-400">Items for sale on the public Shop page.</p>
        </div>
        <a href="{{ route('admin.shop.create') }}" class="rounded-md bg-emerald-500 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-emerald-400">New</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-zinc-800">
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-900/40 text-zinc-300">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Image</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse ($items as $item)
                    <tr class="bg-zinc-950/40">
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $item->title }}</div>
                        </td>
                        <td class="px-4 py-3 text-zinc-300">
                            @if ($item->description)
                                {{ str($item->description)->limit(140) }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-zinc-300">
                            @if ($item->price_cents !== null)
                                ${{ number_format($item->price_cents / 100, 2) }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-zinc-300">
                            {{ $item->is_sold ? 'Sold' : 'For sale' }}
                        </td>
                        <td class="px-4 py-3 text-zinc-300">
                            @if ($item->image_path)
                                <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/'.$item->image_path) }}" alt="" />
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a class="rounded-md border border-zinc-800 px-3 py-1.5 hover:border-zinc-700" href="{{ route('admin.shop.edit', $item) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.shop.destroy', $item) }}" onsubmit="return confirm('Delete this shop item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-md border border-red-900/60 px-3 py-1.5 text-red-200 hover:border-red-800" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-zinc-400" colspan="6">No shop items yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $items->links() }}</div>
@endsection
