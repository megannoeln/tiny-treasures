@extends('layouts.admin')

@section('title', 'Inquiries')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Inquiries</h1>
            <p class="mt-1 text-sm text-zinc-400">Messages sent from the contact form.</p>
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-zinc-800">
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-900/40 text-zinc-300">
                <tr>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">From</th>
                    <th class="px-4 py-3">Received</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse ($inquiries as $inquiry)
                    <tr class="bg-zinc-950/40">
                        <td class="px-4 py-3 text-zinc-300">{{ ucfirst($inquiry->type) }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $inquiry->name ?: '—' }}</div>
                            <div class="text-xs text-zinc-400">{{ $inquiry->email }}</div>
                        </td>
                        <td class="px-4 py-3 text-zinc-300">{{ $inquiry->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a class="rounded-md border border-zinc-800 px-3 py-1.5 hover:border-zinc-700" href="{{ route('admin.inquiries.show', $inquiry) }}">Open</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-zinc-400" colspan="4">No inquiries yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $inquiries->links() }}</div>
@endsection
