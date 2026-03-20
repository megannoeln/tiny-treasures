@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <div class="grid gap-8 lg:grid-cols-12">
        <div class="lg:col-span-6">
            <h1 class="font-serif text-[1.7rem] font-semibold tracking-wide">Contact</h1>
            <p class="mt-3 text-sm text-zinc-400">Commission requests or general questions.</p>

            <div class="mt-6 rounded-xl border border-zinc-800 bg-zinc-900/30 p-6">
                <form class="space-y-4" method="POST" action="{{ route('contact.send') }}">
                    @csrf
                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off" />

                    <div>
                        <label class="label" for="type">Type</label>
                        <select id="type" name="type"
                            class="field mt-1">
                            <option value="general" {{ old('type', $type ?? 'general') === 'general' ? 'selected' : '' }}>General inquiry</option>
                            <option value="commission" {{ old('type', $type ?? 'general') === 'commission' ? 'selected' : '' }}>Commission</option>
                        </select>
                        @error('type')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="label" for="name">Name (optional)</label>
                        <input id="name" name="name" value="{{ old('name') }}"
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
                        <label class="label" for="message">Message</label>
                        <textarea id="message" name="message" rows="6" required
                            class="field mt-1">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-full">
                        Send
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-6">
            <div class="rounded-xl border border-zinc-800 bg-zinc-900/30 p-6">
                <h2 class="text-lg font-semibold">Social</h2>
                <div class="mt-4 flex flex-wrap gap-3 text-sm">
                    <a class="rounded-md border border-zinc-800 px-3 py-1.5 hover:border-zinc-700" href="{{ config('brand.instagram_url', '#') }}" target="_blank" rel="noreferrer">Instagram</a>
                    <a class="rounded-md border border-zinc-800 px-3 py-1.5 hover:border-zinc-700" href="{{ config('brand.facebook_url', '#') }}" target="_blank" rel="noreferrer">Facebook</a>
                </div>
            </div>
        </div>
    </div>
@endsection
