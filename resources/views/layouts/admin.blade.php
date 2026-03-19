<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin') · {{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|cormorant-garamond:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body{font-family:ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,Arial,"Apple Color Emoji","Segoe UI Emoji";}
                .min-h-screen{min-height:100vh}
                .mx-auto{margin-left:auto;margin-right:auto}
                .max-w-6xl{max-width:72rem}
                .px-4{padding-left:1rem;padding-right:1rem}
                .py-4{padding-top:1rem;padding-bottom:1rem}
                .text-sm{font-size:.875rem}
                a{text-decoration:none}
            </style>
        @endif
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 selection:bg-emerald-400 selection:text-zinc-950">
        <header class="border-b border-zinc-800 bg-zinc-950/80 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="font-serif text-xl font-semibold tracking-wide">Admin</a>
                    <nav class="hidden items-center gap-3 text-sm text-zinc-300 sm:flex">
                        <a class="hover:text-white" href="{{ route('admin.portfolio.index') }}">Portfolio</a>
                        <a class="hover:text-white" href="{{ route('admin.events.index') }}">Event</a>
                        <a class="hover:text-white" href="{{ route('admin.classes.index') }}">Class</a>
                        <a class="hover:text-white" href="{{ route('admin.inquiries.index') }}">Inquiries</a>
                        <a class="hover:text-white" href="{{ route('admin.shop.index') }}">Shop</a>
                    </nav>
                </div>

                <div class="flex items-center gap-3">
                    <a href="/" class="btn btn-secondary px-3 py-1.5 no-underline">View site</a>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-secondary px-3 py-1.5" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-8">
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-emerald-900/60 bg-emerald-950/30 px-4 py-3 text-emerald-100">
                    {{ session('status') }}
                </div>
            @endif
            @yield('content')
        </main>
    </body>
</html>
