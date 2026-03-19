@extends('layouts.app')

@section('title', 'Meet the owner · '.config('app.name'))

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight">Meet the owner</h1>
        </div>
        <a href="{{ route('home') }}" class="btn btn-secondary no-underline">Back</a>
    </div>

    <div class="mt-8 flex justify-center">
        <div class="w-full max-w-3xl">
            <div class="card p-6">
                <h2 class="text-lg font-semibold">Hi there,</h2>
                <div class="mt-4 space-y-4 whitespace-pre-wrap text-sm leading-relaxed text-zinc-300">
                    <p>
                        My name is Trinity Joy and I started Tiny Treasures in 2024. I like bugs and art. I decided to put bugs and art together. I am passionate about conservation and take the ethics involved in bug art very seriously. 
                        Outside of Tiny Treasures, when I am not crafting or foraging for natural specimens, I love to read and spend time with my fiance. 
                        I have two cats, two frogs, a snake, and a fish and I have always loved critters and animals of all kinds. I also love to make new friends and meet new people, don't be afraid to reach out to me on my socials if you would like to connect or have any questions at all! :].
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
