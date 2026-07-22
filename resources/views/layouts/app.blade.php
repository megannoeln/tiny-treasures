<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Tiny Treasures')</title>
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
    <body class="min-h-screen bg-zinc-950 text-zinc-100 selection:bg-[#b08a47] selection:text-zinc-950">
        <a href="#content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-xl focus:bg-zinc-950 focus:px-4 focus:py-2">
            Skip to content
        </a>

        <div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <svg class="absolute inset-0 h-full w-full opacity-75" viewBox="0 0 1200 800" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <g fill="#e8d9b0">
                    <path d="M112 126 L116 136 L126 140 L116 144 L112 154 L108 144 L98 140 L108 136 Z" opacity="0.75" />
                    <path d="M278 562 L281 569 L288 572 L281 575 L278 582 L275 575 L268 572 L275 569 Z" opacity="0.6" />
                    <path d="M388 228 L392 238 L402 242 L392 246 L388 256 L384 246 L374 242 L384 238 Z" opacity="0.7" />
                    <path d="M534 666 L537 673 L544 676 L537 679 L534 686 L531 679 L524 676 L531 673 Z" opacity="0.58" />
                    <path d="M646 182 L650 192 L660 196 L650 200 L646 210 L642 200 L632 196 L642 192 Z" opacity="0.78" />
                    <path d="M744 514 L747 521 L754 524 L747 527 L744 534 L741 527 L734 524 L741 521 Z" opacity="0.55" />
                    <path d="M862 274 L866 284 L876 288 L866 292 L862 302 L858 292 L848 288 L858 284 Z" opacity="0.66" />
                    <path d="M972 618 L975 625 L982 628 L975 631 L972 638 L969 631 L962 628 L969 625 Z" opacity="0.56" />
                    <path d="M1058 196 L1062 206 L1072 210 L1062 214 L1058 224 L1054 214 L1044 210 L1054 206 Z" opacity="0.72" />
                    <path d="M1132 436 L1135 443 L1142 446 L1135 449 L1132 456 L1129 449 L1122 446 L1129 443 Z" opacity="0.62" />
                </g>
            </svg>
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
                        <img src="{{ asset($logoPath) }}" alt="{{ config('app.name') }} logo" class="h-11 w-11 rounded-xl object-cover ring-1 ring-zinc-800" decoding="async" />
                    @endif
                    <span class="font-serif text-lg tracking-wide">{{ config('app.name') }}</span>
                </a>

                <nav class="hidden items-center gap-5 text-sm text-zinc-300 sm:flex">
                    <a class="no-underline hover:text-[#5a3f66]" href="{{ route('portfolio.index') }}">Portfolio</a>
                    <a class="no-underline hover:text-[#5a3f66]" href="{{ route('shop.index') }}">Shop</a>
                    <a class="no-underline hover:text-[#5a3f66]" href="{{ route('classes.index') }}">Classes</a>
                    <a class="no-underline hover:text-[#5a3f66]" href="{{ route('about') }}">About</a>
                    <a class="no-underline hover:text-[#5a3f66]" href="{{ route('home') }}#contact">Contact</a>
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
                        <a class="rounded-xl px-3 py-2 no-underline hover:bg-zinc-900/40 hover:text-[#5a3f66]" href="{{ route('portfolio.index') }}">Portfolio</a>
                        <a class="rounded-xl px-3 py-2 no-underline hover:bg-zinc-900/40 hover:text-[#5a3f66]" href="{{ route('shop.index') }}">Shop</a>
                        <a class="rounded-xl px-3 py-2 no-underline hover:bg-zinc-900/40 hover:text-[#5a3f66]" href="{{ route('classes.index') }}">Classes</a>
                        <a class="rounded-xl px-3 py-2 no-underline hover:bg-zinc-900/40 hover:text-[#5a3f66]" href="{{ route('about') }}">About</a>
                        <a class="rounded-xl px-3 py-2 no-underline hover:bg-zinc-900/40 hover:text-[#5a3f66]" href="{{ route('home') }}#contact">Contact</a>
                    </div>
                </nav>
            </div>
        </header>

        <main id="content" class="mx-auto max-w-6xl px-4 py-10">
            @if (session('status'))
                <div data-flash class="mb-6 flex items-start justify-between gap-4 rounded-2xl border border-[#7a6230]/60 bg-[#332a1a]/60 px-4 py-3 text-[#e8d9b0]">
                    <div>{{ session('status') }}</div>
                    <button type="button" class="btn btn-ghost -my-1 -mr-2 px-2 py-1 text-[#e8d9b0]/90" data-flash-close>Close</button>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="border-t border-zinc-800 py-10">
            <div class="mx-auto max-w-6xl px-4 text-sm text-zinc-400">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>© {{ now()->year }} {{ config('app.name') }}</div>
                    <div class="flex items-center gap-4">
                        <a class="no-underline hover:text-[#5a3f66]" href="{{ config('brand.instagram_url', '#') }}" target="_blank" rel="noreferrer">Instagram</a>
                        <a class="no-underline hover:text-[#5a3f66]" href="{{ config('brand.facebook_url', '#') }}" target="_blank" rel="noreferrer">Facebook</a>
                        @auth
                            <a class="no-underline hover:text-[#5a3f66]" href="{{ route('admin.dashboard') }}">Admin</a>
                        @else
                            <a class="no-underline hover:text-[#5a3f66]" href="{{ route('admin.login') }}">Admin</a>
                        @endauth
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
