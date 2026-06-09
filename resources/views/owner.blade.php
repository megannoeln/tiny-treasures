@extends('layouts.app')

@section('title', 'About')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-[1.7rem] font-semibold tracking-wide">About</h1>
        </div>
        <a href="{{ route('home') }}" class="btn btn-secondary no-underline hover:text-[#5a3f66]">Back</a>
    </div>

    <div class="mt-8 flex justify-center">
        <div class="w-full max-w-3xl">
            <div class="card p-6">
                <h2 class="text-lg font-semibold">Hello!</h2>
                <div class="mt-4 space-y-4 text-sm leading-relaxed text-zinc-300">
                    <p>
                        My name is Trinity, the human behind Tiny Treasures. Tiny Treasures started from a love of nature, oddities,
                        and miniatures. I create art and decor using sustainably sourced bones, insects, butterflies, preserved plants,
                        and other natural treasures. All bones used are hand foraged by me from animals of natural passing to ensure that
                        no animal is harmed in the making of my art. Whenever possible, I use locally foraged materials and I always source
                        specimens responsibly. I believe nature is beautiful as it is, and my goal is to preserve and showcase that beauty in
                        a respectful way.
                    </p>
                    <p>
                        In addition to creating art, I also host workshops monthly where people can learn how to make their own 
                        bug/oddity pieces. A huge part of my business is giving back, every ticket sold at my classes supports a local charity.
                        So far this year we have raised over $1,500 for several organizations across the Mahoning valley. Whether you're completely
                        new to oddities or have loved them for years, I want my classes and events to feel welcoming, creative and fun.
                    </p>
                    <p>
                        Thanks for stopping by and supporting my small business. If you have any questions feel free to reach out! :]
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
