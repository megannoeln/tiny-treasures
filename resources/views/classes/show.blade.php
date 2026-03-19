@extends('layouts.app')

@section('title', $classListing->title.' · Classes · '.config('app.name'))

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight">{{ $classListing->title }}</h1>
            <p class="mt-2 text-sm text-zinc-400">
                {{ $classListing->starts_at?->format('M j, Y · g:ia') }}
                @if ($classListing->location) · {{ $classListing->location }} @endif
            </p>
        </div>
        <a href="{{ route('classes.index') }}" class="text-sm text-zinc-300 hover:text-white">Back</a>
    </div>

	    <div class="mt-8 grid gap-8 lg:grid-cols-12">
	        <div class="lg:col-span-7">
	            @if ($classListing->flyer_path)
	                <div class="card overflow-hidden mb-6">
	                    <div class="relative bg-zinc-950 p-3 sm:p-4">
	                        <img class="mx-auto max-h-[75vh] w-full object-contain" src="{{ asset('storage/'.$classListing->flyer_path) }}" alt="Flyer for {{ $classListing->title }}">
                            @if ($classListing->sold_out)
                                <div class="absolute inset-0 flex items-center justify-center bg-zinc-950/65">
                                    <div class="rounded-xl border border-zinc-700 bg-zinc-950/80 px-5 py-3 text-sm font-semibold tracking-wide text-zinc-100">
                                        Sold out
                                    </div>
                                </div>
                            @endif
	                    </div>
	                </div>
	            @endif

	            @if ($classListing->description)
	                <div class="whitespace-pre-wrap text-sm leading-relaxed text-zinc-300">{{ $classListing->description }}</div>
	            @else
	                <div class="text-sm text-zinc-500">No description yet.</div>
	            @endif
	        </div>

	        <div class="lg:col-span-5">
	            <div class="card p-6">
	                <div class="space-y-2 text-sm text-zinc-300">
	                    <div><span class="text-zinc-400">When:</span> {{ $classListing->starts_at?->format('M j, Y · g:ia') }}</div>
	                    @if ($classListing->location)
	                        <div><span class="text-zinc-400">Where:</span> {{ $classListing->location }}</div>
	                    @endif
	                    @if ($classListing->capacity !== null)
	                        <div><span class="text-zinc-400">Capacity:</span> {{ $classListing->capacity }}</div>
	                    @endif
	                    @if ($classListing->price !== null)
	                        <div><span class="text-zinc-400">Price:</span> ${{ number_format((float) $classListing->price, 2) }}</div>
	                    @endif
                        @if ($classListing->deposit !== null)
                            <div><span class="text-zinc-400">Deposit:</span> ${{ number_format((float) $classListing->deposit, 2) }}</div>
                        @endif
                        @if ($classListing->charity_link)
                            <div>
                                <a class="underline decoration-zinc-600 underline-offset-2 hover:decoration-zinc-300" href="{{ $classListing->charity_link }}" target="_blank" rel="noreferrer">Charity Information</a>
                            </div>
                        @endif
	                </div>

	                <h2 class="mt-6 text-lg font-semibold">Sign up</h2>

                    @if ($classListing->sold_out)
                        <p class="mt-2 text-sm text-zinc-400">This class is sold out.</p>
	                    @else
	                        <p class="mt-2 text-sm text-zinc-400">
	                            Spot will not be secured without confirmation from Tiny Treasures and deposit.
                                @if ($classListing->deposit !== null)
                                    Deposit required: ${{ number_format((float) $classListing->deposit, 2) }}.
                                @endif
	                        </p>

                        <form class="mt-5 space-y-4" method="POST" action="{{ route('classes.signup', $classListing) }}">
                            @csrf
                            <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off" />

                            <div>
                                <label class="label" for="name">Name</label>
                                <input id="name" name="name" value="{{ old('name') }}" required
                                    class="field mt-1" />
                                @error('name')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="label" for="email">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                    class="field mt-1" />
                                @error('email')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="label" for="message">Message (optional)</label>
                                <textarea id="message" name="message" rows="5" class="field mt-1">{{ old('message') }}</textarea>
                                @error('message')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-full">
                                Request to sign up
                            </button>
                        </form>
                    @endif
	            </div>
	        </div>
	    </div>
@endsection
