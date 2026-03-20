@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
    <section id="about" class="scroll-mt-28">
        <div class="mx-auto max-w-3xl text-center">
            <h1 class="font-serif text-5xl font-semibold tracking-wide">About</h1>
            <p class="mt-4 text-lg leading-relaxed text-zinc-300">
                Located in Youngstown OH. Ethically and locally sourced. Bugs, bones & oddity miniatures.
            </p>
        </div>
    </section>

    @if ($featuredItems->count())
        <section class="mt-16">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="font-serif text-3xl font-semibold tracking-wide">Featured work</h2>
                    <p class="mt-2 text-sm text-zinc-400">A few personal favorites.</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($featuredItems as $item)
                    @php
                        $href = $item->is_for_sale ? route('shop.show', $item) : route('portfolio.show', $item);
                    @endphp
                    <a href="{{ $href }}" class="card card-hover group overflow-hidden no-underline">
                        <div class="aspect-[4/3] overflow-hidden bg-zinc-950">
                            @if ($item->image_path)
                                <img class="h-full w-full object-cover transition group-hover:scale-[1.02]" src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->title }}">
                            @else
                                <div class="flex h-full items-center justify-center text-sm text-zinc-500">No image</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="text-xs font-semibold uppercase tracking-wide {{ $item->is_for_sale ? 'text-amber-300' : 'text-emerald-300' }}">
                                {{ $item->is_for_sale ? 'Shop' : 'Portfolio' }}
                            </div>
                            <div class="mt-1 font-medium">{{ $item->title }}</div>
                            @if ($item->is_for_sale && $item->price_cents !== null)
                                <div class="text-sm text-zinc-400">${{ number_format($item->price_cents / 100, 2) }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section id="upcoming" class="mt-16 scroll-mt-28">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="font-serif text-3xl font-semibold tracking-wide">Upcoming</h2>
                <p class="mt-2 text-sm text-zinc-400">These are the places you will find us soon!</p>
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
                            <div class="text-xs font-semibold uppercase tracking-wide {{ $item['type'] === 'class' ? 'text-emerald-300' : 'text-amber-300' }}">
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
                                    class="btn btn-secondary px-3 py-1.5 no-underline"
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
            <h2 class="font-serif text-3xl font-semibold tracking-wide">FAQ</h2>
            <div class="mt-8 space-y-4">
                <div class="card p-6">
                    <h3 class="font-semibold">Do you take commissions?</h3>
                    <p class="mt-2 text-sm text-zinc-300">Yes — use the contact form and choose “Commission”.</p>
                </div>
                <div class="card p-6">
                    <h3 class="font-semibold">Where can I see your work in person?</h3>
                    <p class="mt-2 text-sm text-zinc-300">Check the upcoming section for markets and events.</p>
                </div>
                <div class="card p-6">
                    <h3 class="font-semibold">How do class signups work?</h3>
                    <p class="mt-2 text-sm text-zinc-300">Each class page has a signup form, capped by the listed capacity.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="mt-16 scroll-mt-28">
        <div class="grid gap-8 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <h2 class="font-serif text-3xl font-semibold tracking-wide">Contact</h2>
                <p class="mt-3 text-sm text-zinc-400">Let's chat about a commission idea, or general questions.</p>
                <p class="mt-3 text-sm text-zinc-400">
                    Feel free to reach out to my Instagram or Facebook as well.
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
