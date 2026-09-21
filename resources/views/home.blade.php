@extends('layouts.app')

@section('title', 'Tiny Treasures')

@section('content')
    @php
        $nextClass = $upcomingClasses->first();
    @endphp

    @if ($nextClass)
        <section class="mx-auto mb-8 max-w-3xl rounded-2xl border border-[#c7a867]/45 bg-[#c7a867]/10 px-5 py-4 text-center">
            <p class="text-sm text-zinc-100">
                Sign up for our next class, <span class="font-semibold">{{ $nextClass->title }}</span>
                on {{ $nextClass->starts_at->format('M j, Y · g:ia') }}
                <a href="{{ route('classes.show', $nextClass) }}" class="font-semibold text-[#dfcea0] underline decoration-[#c7a867]/70 underline-offset-2 hover:text-white">here</a>.
            </p>
        </section>
    @endif

    @if ($featuredItems->count())
        <section>
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="font-serif text-[1.7rem] font-semibold tracking-wide">Featured artwork</h2>
                </div>
            </div>

            <div class="relative mt-6" data-featured-carousel>
                <div
                    id="featured-artwork-slides"
                    class="featured-carousel-stage"
                    data-featured-carousel-track
                    aria-live="polite"
                >
                    @foreach ($featuredItems as $item)
                        <article
                            class="featured-carousel-slide card overflow-hidden {{ $loop->first ? 'is-active' : 'pointer-events-none is-hidden' }}"
                            data-featured-carousel-slide
                            aria-hidden="{{ $loop->first ? 'false' : 'true' }}"
                        >
                            <div class="aspect-[4/3] overflow-hidden bg-zinc-950">
                                @if ($item->image_path)
                                    <img class="h-full w-full object-cover" src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->title }}">
                                @else
                                    <div class="flex h-full items-center justify-center text-sm text-zinc-500">No image</div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($featuredItems->count() > 1)
                    <button type="button" class="featured-carousel-control featured-carousel-control-previous" data-featured-carousel-previous aria-controls="featured-artwork-slides" aria-label="Show previous artwork">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="m14 6-6 6 6 6" />
                        </svg>
                    </button>
                    <button type="button" class="featured-carousel-control featured-carousel-control-next" data-featured-carousel-next aria-controls="featured-artwork-slides" aria-label="Show next artwork">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="m10 6 6 6-6 6" />
                        </svg>
                    </button>
                @endif
            </div>
        </section>
    @endif

    <section id="upcoming" class="mt-16 scroll-mt-28">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="font-serif text-[1.7rem] font-semibold tracking-wide">Upcoming</h2>
                <p class="mt-2 text-sm text-zinc-400">Where the mossy path leads us next.</p>
            </div>
        </div>

        <div class="mt-6 space-y-3">
            @forelse ($upcoming as $item)
                @php
                    $href = $item['type'] === 'event' ? ($item['url'] ?: null) : $item['url'];
                @endphp
                <div class="card p-4">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wide {{ $item['type'] === 'class' ? 'text-[#c7a867]' : 'text-[#5a3f66]' }}">
                                {{ $item['type'] === 'class' ? 'Class' : 'Event' }}
                            </div>
                            <div class="mt-1 font-semibold">{{ $item['title'] }}</div>
                            <div class="text-sm text-zinc-400">
                                {{ $item['starts_at']->format('M j, Y · g:ia') }}
                                @if ($item['location']) · {{ $item['location'] }} @endif
                            </div>
                        </div>
                        <div>
                            @if ($href)
                                <a
                                    href="{{ $href }}"
                                    class="btn btn-secondary px-3 py-1.5 no-underline {{ $item['type'] === 'class' ? 'hover:text-[#c7a867]' : 'hover:text-[#5a3f66]' }}"
                                    @if ($item['type'] === 'event') target="_blank" rel="noreferrer" @endif
                                >Details</a>
                            @else
                                <span class="text-sm text-zinc-500">Link soon</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-sm text-zinc-500">Nothing upcoming yet.</div>
            @endforelse
        </div>
    </section>

    <section id="faq" class="mt-16 scroll-mt-28">
        <div class="max-w-3xl">
            <h2 class="font-serif text-[1.7rem] font-semibold tracking-wide">FAQ</h2>
            <div class="mt-8 space-y-4">
                <div class="card p-6">
                    <h3 class="font-semibold">Can I request a custom piece?</h3>
                    <p class="mt-2 text-sm text-zinc-300">Absolutely! Feel free to reach out with your idea using the Contact
                        form, choose "Commission", and I will let you know if it's something that I can create.
                    </p>
                </div>
                <div class="card p-6">
                    <h3 class="font-semibold">How do class signups work?</h3>
                    <p class="mt-2 text-sm text-zinc-300">You can use the signup form on the class page and I will respond via email to handle reserving your spot, or you can reach me on Instagram!</p>
                </div>
                <div class="card p-6">
                    <h3 class="font-semibold">Do you offer shipping?</h3>
                    <p class="mt-2 text-sm text-zinc-300">Yes! Shipping availability may vary by item. Please feel free to
                     contact me if you have questions about shipping or local pickup!</p>
                </div>
                <div class="card p-6">
                    <h3 class="font-semibold">Are the butterflies and insects real?</h3>
                    <p class="mt-2 text-sm text-zinc-300">Yes, unless otherwise noted all specimens are real and have been preserved for display.</p>
                </div>
                <div class="card p-6">
                    <h3 class="font-semibold">What does sustainably sourced mean?</h3>
                    <p class="mt-2 text-sm text-zinc-300">Sustainably sourced means all specimens that were not hand-foraged 
                        of natural passing, were sourced from a licensed entomologist who provides specimens that have reproduced
                        in captivity for educational purposes and passed naturally. For animals, it means that all bones were hand-foraged
                        of animals of natural passing. Foraged materials such as moss, ferns, lichens, seed pods, and other natural 
                        goodies are gathered responsibly using sustainable foraging practices that avoid damaging ecosystems,
                        disturbing wildlife habitats, or depleting native plant populations.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="mt-16 scroll-mt-28">
        <div class="grid gap-8 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <h2 class="font-serif text-[1.7rem] font-semibold tracking-wide">Contact</h2>
                <p class="mt-3 text-sm text-zinc-400">Let's chat about a commission idea, or general questions.</p>
                <p class="mt-3 text-sm text-zinc-400">
                    Feel free to reach out to my Instagram as well.
                </p>
            </div>

            <div class="lg:col-span-7">
                <div class="card p-6">
                    <form class="space-y-4" method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off" />

                        <div>
                            <label class="label" for="type">Type</label>
                            <select id="type" name="type" class="field mt-1">
                                <option value="general" {{ old('type', $contactType) === 'general' ? 'selected' : '' }}>General inquiry</option>
                                <option value="commission" {{ old('type', $contactType) === 'commission' ? 'selected' : '' }}>Commission</option>
                            </select>
                            @error('type')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="label" for="name">Name (optional)</label>
                                <input id="name" name="name" value="{{ old('name') }}" class="field mt-1" />
                                @error('name')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="label" for="email">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="field mt-1" />
                                @error('email')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="label" for="message">Message</label>
                            <textarea id="message" name="message" rows="6" required class="field mt-1">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-full">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
