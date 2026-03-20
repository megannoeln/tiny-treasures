@extends('layouts.app')

@section('title', 'Calendar · '.config('app.name'))

@section('content')
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-serif text-[1.7rem] font-semibold tracking-wide">Calendar</h1>
            <p class="mt-2 text-sm text-zinc-400">Upcoming markets and classes.</p>
        </div>

        <div class="flex items-center gap-2 text-sm">
            <a class="btn btn-secondary px-3 py-1.5 no-underline"
                href="{{ route('calendar', ['month' => $monthStart->subMonth()->format('Y-m')]) }}">Prev</a>
            <div class="text-zinc-300">{{ $monthStart->format('F Y') }}</div>
            <a class="btn btn-secondary px-3 py-1.5 no-underline"
                href="{{ route('calendar', ['month' => $monthStart->addMonth()->format('Y-m')]) }}">Next</a>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-xl border border-zinc-800">
        <div class="grid grid-cols-7 bg-zinc-900/40 text-xs font-semibold uppercase tracking-wide text-zinc-300">
            @foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $dow)
                <div class="px-3 py-2">{{ $dow }}</div>
            @endforeach
        </div>
        <div class="divide-y divide-zinc-800">
            @foreach ($calendar as $week)
                <div class="grid grid-cols-7 divide-x divide-zinc-800">
                    @foreach ($week as $day)
                        <div class="min-h-28 bg-zinc-950/40 px-3 py-2">
                            <div class="flex items-center justify-between">
                                <div class="text-xs {{ $day['in_month'] ? 'text-zinc-300' : 'text-zinc-600' }}">
                                    {{ $day['date']->day }}
                                </div>
                            </div>
                            <div class="mt-2 space-y-1">
                                @foreach ($day['items'] as $item)
                                    <a href="{{ $item['url'] }}" class="block truncate rounded-md border border-zinc-800 bg-zinc-900/30 px-2 py-1 text-xs text-zinc-200 hover:border-zinc-700">
                                        <span class="font-semibold {{ $item['type'] === 'class' ? 'text-[#c7a867]' : 'text-amber-300' }}">
                                            {{ $item['type'] === 'class' ? 'Class' : 'Market' }}
                                        </span>
                                        <span class="text-zinc-300">{{ $item['time'] }}</span>
                                        <span class="text-zinc-100">{{ $item['title'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <h2 class="mt-10 text-lg font-semibold">Upcoming list</h2>
    <div class="mt-4 space-y-3">
        @forelse ($upcoming as $item)
            <div class="card p-4">
                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wide {{ $item['type'] === 'class' ? 'text-[#c7a867]' : 'text-amber-300' }}">
                            {{ $item['type'] }}
                        </div>
                        <div class="mt-1 font-semibold">{{ $item['title'] }}</div>
                        <div class="text-sm text-zinc-400">
                            {{ $item['starts_at']->format('M j, Y · g:ia') }}
                            @if ($item['location']) · {{ $item['location'] }} @endif
                        </div>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        <a href="{{ $item['url'] }}" class="btn btn-secondary px-3 py-1.5 no-underline hover:text-[#5a3f66]">Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-sm text-zinc-500">Nothing upcoming yet.</div>
        @endforelse
    </div>
@endsection
