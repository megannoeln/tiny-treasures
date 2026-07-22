<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Login · {{ config('app.name') }}</title>
        @php
            $faviconPath = 'favicon.png';
            $faviconVersion = is_file(public_path($faviconPath)) ? filemtime(public_path($faviconPath)) : null;
        @endphp
        <link rel="icon" type="image/png" href="{{ asset($faviconPath) }}@if($faviconVersion)?v={{ $faviconVersion }}@endif">
        <link rel="apple-touch-icon" href="{{ asset($faviconPath) }}@if($faviconVersion)?v={{ $faviconVersion }}@endif">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|cinzel:400,500,600" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body{font-family:ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,Arial,"Apple Color Emoji","Segoe UI Emoji";}
                .min-h-screen{min-height:100vh}
            </style>
        @endif
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 selection:bg-[#b08a47] selection:text-zinc-950">
        <div class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-4 py-12">
            <h1 class="font-serif text-[1.4rem] font-semibold tracking-wide">Admin Login</h1>
            <p class="mt-1 text-sm text-zinc-400">Sign in to manage the site.</p>

            <form class="mt-8 space-y-4 rounded-xl border border-zinc-800 bg-zinc-900/30 p-6" method="POST" action="{{ route('admin.login.store') }}">
                @csrf

                <div>
                    <label class="text-sm text-zinc-300" for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="field mt-1" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-zinc-300" for="password">Password</label>
                    <input id="password" name="password" type="password" required
                        class="field mt-1" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-zinc-300">
                    <input type="checkbox" name="remember" value="1" class="rounded border-zinc-700 bg-zinc-950">
                    Remember me
                </label>

                <button type="submit" class="btn btn-primary w-full">
                    Sign in
                </button>
            </form>
        </div>
    </body>
</html>
