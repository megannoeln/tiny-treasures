@extends('layouts.app')

@section('title', 'FAQ · '.config('app.name'))

@section('content')
    <div class="max-w-3xl">
        <h1 class="text-3xl font-semibold tracking-tight">FAQ</h1>
        <div class="mt-8 space-y-6">
            <div class="rounded-xl border border-zinc-800 bg-zinc-900/30 p-6">
                <h2 class="font-semibold">Do you take commissions?</h2>
                <p class="mt-2 text-sm text-zinc-300">Yes — use the contact form and choose “Commission”.</p>
            </div>
            <div class="rounded-xl border border-zinc-800 bg-zinc-900/30 p-6">
                <h2 class="font-semibold">Where can I see your work in person?</h2>
                <p class="mt-2 text-sm text-zinc-300">Check the calendar for upcoming markets and events.</p>
            </div>
            <div class="rounded-xl border border-zinc-800 bg-zinc-900/30 p-6">
                <h2 class="font-semibold">What’s included in classes?</h2>
                <p class="mt-2 text-sm text-zinc-300">Each class page includes the flyer, details, and signup availability.</p>
            </div>
        </div>
    </div>
@endsection

