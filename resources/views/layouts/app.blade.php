<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ str($title)->headline() }} | {{ config('app.name') }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-zinc-950 antialiased" x-data="{ sidebarOpen: false, profileMenuOpen: false }"
    @keydown.escape.window="sidebarOpen = false; profileMenuOpen = false">

    {{-- Navigation bar --}}
    <nav class="block w-full sticky top-0 z-50 bg-zinc-800">
        <div class="mx-auto container max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="w-full flex flex-row gap-4 items-center justify-between">

                {{-- Logo link --}}
                <a href="{{ url('/') }}" class="block text-2xl text-blue-600 font-bold py-2">
                    Laravel
                </a>
                {{-- Authenticated user links --}}
                @auth
                    <div class="flex flex-row gap-4 items-center">
                        <x-navbar-link :url="route('welcome')" text="Welcome" />
                        <x-navbar-link :url="route('user.home')" text="Home" />
                        <x-navbar-link :url="route('user.settings') . '#personal-information'" text="Settings" />
                        <x-navbar-link logout text="Logout" />
                    </div>
                @endauth
                {{-- Guest user links --}}
                @guest
                    <div class="flex flex-row gap-4 items-center">
                        <x-navbar-link :url="route('login')" text="Login" />
                        <x-navbar-link :url="route('register')" text="Register" />
                    </div>
                @endguest
            </div>
        </div>

        {{-- Secondary navigation or additional links can go here --}}
        <div class="mx-auto container max-w-5xl px-4 sm:px-6 lg:px-8 border-t border-zinc-600 py-2">
            <div class="w-full flex flex-row gap-4 items-center justify-center">
                @yield('sidebar-context')
            </div>
        </div>
    </nav>

    <div class="flex flex-col items-stretch min-h-screen">
        <header class="w-full bg-indigo-600 ">



        </header>

        <main class="min-w-0 flex-1 bg-zinc-950 p-4">
            @yield('content')
        </main>

        <footer class="bg-black min-h-16 w-full">

        </footer>
    </div>



    {{-- <div class="flex row min-h-screen"> --}}
    {{-- <aside class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:left-0 lg:w-72 lg:z-40 lg:shrink-0">

            <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-slate-200 bg-white px-6 pb-4">

                @include('layouts.partials.sidebar')

                <x-app-sidebar-links />
            </div>

        </aside> --}}

    {{-- <main class="min-w-0 flex-1 min-h-screen px-4 py-8 lg:ml-72">


                <div class="flex row items-center gap-4">
                    <a href="{{ url('/') }}"
                        class="flex min-w-0 flex-1 items-center gap-3 rounded-sm focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-amber-500">
                        <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-amber-400 text-slate-950"
                            aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" class="size-5" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 7h14M5 12h9M5 17h14" />
                            </svg>
                        </span>
                        <span class="truncate text-base font-semibold">{{ config('app.name') }}</span>
                    </a>
                </div>
                <h1 class="text-2xl font-bold">{{ str($title)->headline() }}</h1>
            </header>

            <div>

                @yield('content')
            </div>
            <footer class="bg-slate-100 p-4 text-center text-sm text-slate-500">

                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </footer>

        </main> --}}

    {{-- </div> --}}



    {{-- <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-x-4 px-4">


            @auth

                <div class="min-w-0 flex-1">
                    <p class="hidden text-xs font-medium text-slate-500 sm:block">{{ config('app.name') }}</p>
                    <h1 class="truncate text-base font-semibold text-slate-900">{{ str($title)->headline() }}</h1>
                </div>

                <div class="relative" @click.outside="profileMenuOpen = false">
                    <button type="button"
                        class="flex max-w-56 items-center gap-3 rounded-md p-1.5 text-left hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500"
                        aria-haspopup="true" aria-controls="profile-menu" :aria-expanded="profileMenuOpen.toString()"
                        @click="profileMenuOpen = !profileMenuOpen">
                        <span
                            class="grid size-9 shrink-0 place-items-center rounded-full bg-slate-900 text-sm font-semibold text-white">
                            {{ str(auth()->user()->name)->substr(0, 1)->upper() }}
                        </span>
                        <span class="hidden min-w-0 sm:block">
                            <span
                                class="block truncate text-sm font-medium text-slate-900">{{ auth()->user()->name }}</span>
                            <span class="block truncate text-xs text-slate-500">{{ auth()->user()->email }}</span>
                        </span>
                        <svg class="hidden size-4 shrink-0 text-slate-500 sm:block" :class="profileMenuOpen && 'rotate-180'"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="profile-menu" x-cloak x-show="profileMenuOpen" x-transition.origin.top.right
                        class="absolute right-0 z-50 mt-2 w-52 rounded-md border border-slate-200 bg-white p-1 shadow-lg"
                        role="menu">
                        <a href="{{ route('user.settings') }}"
                            class="block rounded px-3 py-2 text-sm text-slate-700 hover:bg-slate-100" role="menuitem"
                            @click="profileMenuOpen = false">
                            Podešavanja naloga
                        </a>

                    </div>
                </div>
            @else
                <nav aria-label="Korisnički nalog" class="flex shrink-0 items-center gap-2">
                    @if (!request()->routeIs('login'))
                        <a href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950">Prijava</a>
                    @endif
                    @if (!request()->routeIs('register'))
                        <a href="{{ route('register') }}"
                            class="rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">Registracija</a>
                    @endif
                </nav>
            @endauth

        </div> --}}

</body>

</html>
