@extends('layouts.app')

@section('title', 'Classes · '.config('app.name'))

@section('content')
    <div>
        <h1 class="font-serif text-[1.7rem] font-semibold tracking-wide">Classes</h1>
        <p class="mt-2 text-sm text-zinc-400">Details and signups.</p>
    </div>

    <div class="mt-8 grid gap-4 lg:grid-cols-2">
        @forelse ($classes as $class)
            <a href="{{ route('classes.show', $class) }}" class="card card-hover p-5 no-underline">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-lg font-semibold">{{ $class->title }}</div>
                        <div class="mt-1 text-sm text-zinc-400">
                            {{ $class->starts_at?->format('M j, Y · g:ia') }}
                            @if ($class->location) · {{ $class->location }} @endif
                        </div>
                        @if ($class->capacity)
                            <div class="mt-2 text-sm text-zinc-400">Capacity: {{ $class->capacity }}</div>
                        @endif
                        @if ($class->price !== null)
                            <div class="mt-2 text-sm text-zinc-400">${{ number_format((float) $class->price, 2) }}</div>
                        @endif
                    </div>
                    <div class="text-sm text-[#5a3f66]">Details →</div>
                </div>
            </a>
        @empty
            <div class="text-sm text-zinc-500">No classes posted yet.</div>
        @endforelse
    </div>

    <div class="mt-8">{{ $classes->links() }}</div>
@endsection
