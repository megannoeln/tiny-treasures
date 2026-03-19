@extends('layouts.admin')

@section('title', 'Classes')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Classes</h1>
            <p class="mt-1 text-sm text-zinc-400">Classes show on the site and calendar.</p>
        </div>
        <a href="{{ route('admin.classes.create') }}" class="rounded-md bg-emerald-500 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-emerald-400">New</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-zinc-800">
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-900/40 text-zinc-300">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Starts</th>
                    <th class="px-4 py-3">Capacity</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Deposit</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse ($classes as $class)
                    <tr class="bg-zinc-950/40">
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $class->title }}</div>
                        </td>
                        <td class="px-4 py-3 text-zinc-300">{{ $class->starts_at?->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 text-zinc-300">{{ $class->capacity ?? '—' }}</td>
                        <td class="px-4 py-3 text-zinc-300">
                            @if ($class->price !== null)
                                ${{ number_format((float) $class->price, 2) }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-zinc-300">
                            @if ($class->deposit !== null)
                                ${{ number_format((float) $class->deposit, 2) }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a class="rounded-md border border-zinc-800 px-3 py-1.5 hover:border-zinc-700" href="{{ route('admin.classes.edit', $class) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" onsubmit="return confirm('Delete this class?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-md border border-red-900/60 px-3 py-1.5 text-red-200 hover:border-red-800" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-zinc-400" colspan="6">No classes yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $classes->links() }}</div>
@endsection
