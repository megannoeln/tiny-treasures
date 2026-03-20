@extends('layouts.admin')

@section('title', 'Attendees')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-[1.4rem] font-semibold tracking-wide">Attendees</h1>
            <p class="mt-1 text-sm text-zinc-400">
                {{ $classListing->title }} ·
                {{ $classListing->starts_at?->format('Y-m-d H:i') }}
                @if ($classListing->capacity !== null)
                    · {{ $classListing->attendees()->count() }}/{{ $classListing->capacity }}
                @endif
            </p>
        </div>
        <a href="{{ route('admin.classes.index') }}" class="text-sm text-zinc-300 hover:text-[#5a3f66]">Back</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-zinc-800">
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-900/40 text-zinc-300">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Signed up</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse ($attendees as $attendee)
                    <tr class="bg-zinc-950/40">
                        <td class="px-4 py-3 font-medium">{{ $attendee->name }}</td>
                        <td class="px-4 py-3 text-zinc-300">{{ $attendee->email }}</td>
                        <td class="px-4 py-3 text-zinc-300">{{ $attendee->created_at?->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-zinc-400" colspan="3">No attendees yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $attendees->links() }}</div>
@endsection

