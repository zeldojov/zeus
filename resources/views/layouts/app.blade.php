<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | {{ config('app.name') }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-white text-slate-900 antialiased">
    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
        <nav
            class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
            aria-label="Glavna navigacija"
            x-data="{ mobileMenuOpen: false, accountMenuOpen: false }"
            @keydown.escape.window="mobileMenuOpen = false; accountMenuOpen = false"
        >
            <div class="flex h-16 items-center justify-between gap-4">
                <a href="{{ url('/') }}" class="flex min-w-0 items-center gap-3 rounded-sm focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-amber-500">
                    <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-amber-400 text-slate-950" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" class="size-5" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 7h14M5 12h9M5 17h14" />
                        </svg>
                    </span>
                    <span class="truncate text-base font-semibold">{{ config('app.name') }}</span>
                </a>

                <div class="hidden items-center gap-2 sm:flex">
                    <a href="{{ url('/') }}"
                        @class([
                            'rounded-md px-3 py-2 text-sm font-medium transition-colors hover:bg-slate-100 hover:text-slate-950',
                            'bg-slate-100 text-slate-950' => request()->is('/'),
                            'text-slate-600' => !request()->is('/'),
                        ])>
                        Početna
                    </a>

                    @auth
                        <a href="{{ url('/home') }}"
                            @class([
                                'rounded-md px-3 py-2 text-sm font-medium transition-colors hover:bg-slate-100 hover:text-slate-950',
                                'bg-slate-100 text-slate-950' => request()->is('home'),
                                'text-slate-600' => !request()->is('home'),
                            ])>
                            Panel
                        </a>

                        <div class="relative ml-2 border-l border-slate-200 pl-4" @click.outside="accountMenuOpen = false">
                            <button
                                x-ref="accountButton"
                                type="button"
                                class="flex max-w-56 items-center gap-3 rounded-md px-2 py-1.5 text-left hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500"
                                aria-haspopup="true"
                                :aria-expanded="accountMenuOpen.toString()"
                                @click="accountMenuOpen = !accountMenuOpen"
                            >
                                <span class="grid size-9 shrink-0 place-items-center rounded-full bg-slate-900 text-sm font-semibold text-white">
                                    {{ str(auth()->user()->name)->substr(0, 1)->upper() }}
                                </span>
                                <span class="min-w-0">
                                    <span class="block truncate text-sm font-medium text-slate-900">{{ auth()->user()->name }}</span>
                                    <span class="block truncate text-xs text-slate-500">{{ auth()->user()->email }}</span>
                                </span>
                                <svg class="size-4 shrink-0 text-slate-500 transition-transform" :class="accountMenuOpen && 'rotate-180'" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div
                                x-cloak
                                x-show="accountMenuOpen"
                                x-transition.origin.top.right
                                class="absolute right-0 z-40 mt-2 w-52 rounded-md border border-slate-200 bg-white p-1 shadow-lg"
                                role="menu"
                            >
                                <a href="{{ url('/home') }}" class="block rounded px-3 py-2 text-sm text-slate-700 hover:bg-slate-100" role="menuitem" @click="accountMenuOpen = false">
                                    Otvori panel
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full rounded px-3 py-2 text-left text-sm text-rose-700 hover:bg-rose-50" role="menuitem">
                                        Odjavi se
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-100 hover:text-slate-950">
                            Prijava
                        </a>
                        <a href="{{ route('register') }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                            Registracija
                        </a>
                    @endauth
                </div>

                <button
                    type="button"
                    class="grid size-10 shrink-0 place-items-center rounded-md text-slate-700 hover:bg-slate-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500 sm:hidden"
                    aria-label="Otvori navigaciju"
                    aria-controls="mobile-navigation"
                    :aria-expanded="mobileMenuOpen.toString()"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                >
                    <svg x-cloak x-show="!mobileMenuOpen" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <svg x-cloak x-show="mobileMenuOpen" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
                    </svg>
                </button>
            </div>

            <div id="mobile-navigation" x-cloak x-show="mobileMenuOpen" x-transition class="border-t border-slate-200 py-3 sm:hidden">
                <div class="grid gap-1">
                    <a href="{{ url('/') }}" class="rounded-md px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100" @click="mobileMenuOpen = false">
                        Početna
                    </a>

                    @auth
                        <a href="{{ url('/home') }}" class="rounded-md px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100" @click="mobileMenuOpen = false">
                            Panel
                        </a>
                        <div class="mt-2 border-t border-slate-200 px-3 pt-3">
                            <p class="truncate text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button type="submit" class="w-full rounded-md px-3 py-2.5 text-left text-sm font-medium text-rose-700 hover:bg-rose-50">
                                Odjavi se
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100" @click="mobileMenuOpen = false">
                            Prijava
                        </a>
                        <a href="{{ route('register') }}" class="rounded-md bg-slate-900 px-3 py-2.5 text-sm font-semibold text-white hover:bg-slate-700" @click="mobileMenuOpen = false">
                            Registracija
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @yield('content')
    </main>
</body>

</html>
