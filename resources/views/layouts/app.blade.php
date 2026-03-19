<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name'))</title>

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
                .py-10{padding-top:2.5rem;padding-bottom:2.5rem}
                .text-sm{font-size:.875rem}
                a{text-decoration:none}
            </style>
        @endif
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 selection:bg-emerald-400 selection:text-zinc-950">
        <a href="#content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-xl focus:bg-zinc-950 focus:px-4 focus:py-2">
            Skip to content
        </a>

        <div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-24 left-1/2 h-[28rem] w-[28rem] -translate-x-1/2 rounded-full bg-emerald-500/10 blur-3xl"></div>
            <div class="absolute top-1/2 right-[-10rem] h-[26rem] w-[26rem] -translate-y-1/2 rounded-full bg-amber-500/10 blur-3xl"></div>
        </div>

        <header class="sticky top-0 z-40 border-b border-zinc-800 bg-zinc-950/80 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4">
                @php
                    $configuredLogoPath = ltrim((string) config('brand.logo_path'), '/');
                    $candidates = [
                        $configuredLogoPath,
                        'images/tinytreasureslogo.jpg',
                        'images/tinytreasureslogo.jpeg',
                        'images/tinytreasureslogo.png',
                        'images/tinytreasureslogo.webp',
                        'images/logo.svg',
                        'images/logo.webp',
                        'images/logo.png',
                        'images/logo.jpg',
                        'images/logo.jpeg',
                    ];

                    $logoPath = null;
                    foreach ($candidates as $candidate) {
                        if (! $candidate) {
                            continue;
                        }
                        $fullPath = public_path($candidate);
                        if (is_file($fullPath) && filesize($fullPath) > 0) {
                            $logoPath = $candidate;
                            break;
                        }
                    }
                    $hasLogo = $logoPath !== null;
                    $instagramUrl = (string) config('brand.instagram_url');
                    $facebookUrl = (string) config('brand.facebook_url');
                @endphp
                <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold tracking-tight no-underline hover:opacity-95">
                    @if ($hasLogo)
                        <img src="{{ asset($logoPath) }}" alt="{{ config('app.name') }} logo" class="h-10 w-10 rounded-xl object-cover ring-1 ring-zinc-800" decoding="async" />
                    @endif
                    <span class="font-serif text-xl tracking-wide">{{ config('app.name') }}</span>
                </a>

                <nav class="hidden items-center gap-5 text-sm text-zinc-300 sm:flex">
                    <a class="no-underline hover:text-white" href="{{ route('portfolio.index') }}">Portfolio</a>
                    <a class="no-underline hover:text-white" href="{{ route('shop.index') }}">Shop</a>
                    <a class="no-underline hover:text-white" href="{{ route('classes.index') }}">Classes</a>
                    <a class="no-underline hover:text-white" href="{{ route('owner') }}">Meet the owner</a>
                    <a class="no-underline hover:text-white" href="{{ route('home') }}#contact">Contact</a>
                </nav>

                <div class="flex items-center gap-1">
                    @if ($instagramUrl)
                        <a class="rounded-lg p-2 text-zinc-300 hover:bg-zinc-900/40 hover:text-white" href="{{ $instagramUrl }}" target="_blank" rel="noreferrer" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3.5" y="3.5" width="17" height="17" rx="4.5"></rect>
                                <path d="M12 16.2a4.2 4.2 0 1 0 0-8.4 4.2 4.2 0 0 0 0 8.4Z"></path>
                                <path d="M17.3 6.7h.01"></path>
                            </svg>
                        </a>
                    @endif
                    @if ($facebookUrl)
                        <a class="rounded-lg p-2 text-zinc-300 hover:bg-zinc-900/40 hover:text-white" href="{{ $facebookUrl }}" target="_blank" rel="noreferrer" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                                <path d="M13.5 22v-8.2h2.8l.4-3.2h-3.2V8.6c0-.9.3-1.6 1.7-1.6h1.7V4.1c-.3 0-1.4-.1-2.7-.1-2.7 0-4.6 1.6-4.6 4.7v1.9H7v3.2h2.6V22h3.9Z"></path>
                            </svg>
                        </a>
                    @endif

                    <button
                        type="button"
                        class="btn btn-secondary sm:hidden"
                        data-mobile-nav-button
                        aria-controls="mobile-nav"
                        aria-expanded="false"
                    >
                        Menu
                    </button>
                </div>
            </div>

            <div class="hidden border-t border-zinc-800 bg-zinc-950/95 sm:hidden" id="mobile-nav" data-mobile-nav>
                <nav class="mx-auto max-w-6xl px-4 py-4 text-sm text-zinc-200">
                    <div class="grid gap-2">
                        <a class="rounded-xl px-3 py-2 no-underline hover:bg-zinc-900/40" href="{{ route('portfolio.index') }}">Portfolio</a>
                        <a class="rounded-xl px-3 py-2 no-underline hover:bg-zinc-900/40" href="{{ route('shop.index') }}">Shop</a>
                        <a class="rounded-xl px-3 py-2 no-underline hover:bg-zinc-900/40" href="{{ route('classes.index') }}">Classes</a>
                        <a class="rounded-xl px-3 py-2 no-underline hover:bg-zinc-900/40" href="{{ route('owner') }}">Meet the owner</a>
                        <a class="rounded-xl px-3 py-2 no-underline hover:bg-zinc-900/40" href="{{ route('home') }}#contact">Contact</a>
                    </div>
                </nav>
            </div>
        </header>

        <main id="content" class="mx-auto max-w-6xl px-4 py-10">
            @if (session('status'))
                <div data-flash class="mb-6 flex items-start justify-between gap-4 rounded-2xl border border-emerald-900/60 bg-emerald-950/30 px-4 py-3 text-emerald-100">
                    <div>{{ session('status') }}</div>
                    <button type="button" class="btn btn-ghost -my-1 -mr-2 px-2 py-1 text-emerald-100/90" data-flash-close>Close</button>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="border-t border-zinc-800 py-10">
            <div class="mx-auto max-w-6xl px-4 text-sm text-zinc-400">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>© {{ now()->year }} {{ config('app.name') }}</div>
                    <div class="flex items-center gap-4">
                        <a class="no-underline hover:text-emerald-200" href="{{ config('brand.instagram_url', '#') }}" target="_blank" rel="noreferrer">Instagram</a>
                        <a class="no-underline hover:text-amber-200" href="{{ config('brand.facebook_url', '#') }}" target="_blank" rel="noreferrer">Facebook</a>
                        @auth
                            <a class="no-underline hover:text-zinc-200" href="{{ route('admin.dashboard') }}">Admin</a>
                        @else
                            <a class="no-underline hover:text-zinc-200" href="{{ route('admin.login') }}">Admin</a>
                        @endauth
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
