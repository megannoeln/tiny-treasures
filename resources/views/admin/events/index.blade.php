@extends('layouts.admin')

@section('title', 'Events')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-[1.4rem] font-semibold tracking-wide">Events</h1>
            <p class="mt-1 text-sm text-zinc-400">Markets, pop-ups, and other appearances.</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="rounded-md bg-[#7a6230] px-4 py-2 text-sm font-semibold text-[#f5ecd3] hover:bg-[#8c733b]">New</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-zinc-800">
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-900/40 text-zinc-300">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Starts</th>
                    <th class="px-4 py-3">Ends</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse ($events as $event)
                    <tr class="bg-zinc-950/40">
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $event->name }}</div>
                            @if ($event->external_link)
                                <div class="text-xs text-zinc-400">{{ $event->external_link }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-zinc-300">{{ $event->starts_at?->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 text-zinc-300">
                            @if ($event->ends_at)
                                {{ $event->ends_at->format('Y-m-d H:i') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a class="rounded-md border border-zinc-800 px-3 py-1.5 hover:border-zinc-700" href="{{ route('admin.events.edit', $event) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this event?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-md border border-red-900/60 px-3 py-1.5 text-red-200 hover:border-red-800" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-zinc-400" colspan="4">No events yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $events->links() }}</div>
@endsection
