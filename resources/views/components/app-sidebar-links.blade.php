<nav aria-label="Glavna navigacija" class="flex flex-1 flex-col">
    <div class="mb-3 px-2 text-xs font-semibold uppercase text-slate-400">Navigacija</div>
    <ul class="flex flex-col gap-1">
        <li>
            <a href="{{ url('/') }}"
                @class([
                    'group flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors',
                    'bg-amber-50 text-amber-800' => request()->path() === '',
                    'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => request()->path() !== '',
                ])
                @if (request()->path() === '') aria-current="page" @endif
            >
                <svg class="size-5 shrink-0 text-current" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V10Z" />
                </svg>
                <span>Početna</span>
            </a>
        </li>
        @auth
            <li>
                <a href="{{ route('user.home') }}"
                    @class([
                        'group flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors',
                        'bg-amber-50 text-amber-800' => request()->routeIs('user.home'),
                        'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => !request()->routeIs('user.home'),
                    ])
                    @if (request()->routeIs('user.home')) aria-current="page" @endif
                >
                    <svg class="size-5 shrink-0 text-current" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5m0 14h16M8 16v-4m4 4V8m4 8v-6m4 6V4" />
                    </svg>
                    <span>Panel</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.settings') }}"
                    @class([
                        'group flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors',
                        'bg-amber-50 text-amber-800' => request()->routeIs('user.settings'),
                        'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => !request()->routeIs('user.settings'),
                    ])
                    @if (request()->routeIs('user.settings')) aria-current="page" @endif
                >
                    <svg class="size-5 shrink-0 text-current" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.4 15 .1.1a1.8 1.8 0 1 1-2.55 2.55l-.1-.1a1.8 1.8 0 0 0-3.06 1.27v.28a1.8 1.8 0 1 1-3.6 0v-.15A1.8 1.8 0 0 0 7.1 17.7l-.1.1a1.8 1.8 0 1 1-2.55-2.55l.1-.1a1.8 1.8 0 0 0-1.27-3.06H3a1.8 1.8 0 1 1 0-3.6h.15A1.8 1.8 0 0 0 4.4 5.3l-.1-.1a1.8 1.8 0 1 1 2.55-2.55l.1.1a1.8 1.8 0 0 0 3.06-1.27V1.2a1.8 1.8 0 1 1 3.6 0v.15A1.8 1.8 0 0 0 16.9 2.7l.1-.1a1.8 1.8 0 1 1 2.55 2.55l-.1.1a1.8 1.8 0 0 0 1.27 3.06H21a1.8 1.8 0 1 1 0 3.6h-.15A1.8 1.8 0 0 0 19.4 15Z" transform="translate(1.5 1.5) scale(.875)" />
                    </svg>
                    <span>Podešavanja</span>
                </a>
            </li>
        @endauth
    </ul>

    @hasSection('sidebar-context')
        <div class="mt-4 border-t border-slate-200 pt-4">
            <p class="mb-3 px-2 text-xs font-semibold uppercase text-slate-400">Na ovoj stranici</p>
            <nav aria-label="Navigacija na ovoj stranici" class="flex flex-col gap-1" @click="sidebarOpen = false">
                @yield('sidebar-context')
            </nav>
        </div>
    @endif

    <div class="mt-auto border-t border-slate-200 pt-4">
        @auth
            <div class="flex items-center gap-3 px-2 py-2">
                <span class="grid size-9 shrink-0 place-items-center rounded-full bg-slate-900 text-sm font-semibold text-white">
                    {{ str(auth()->user()->name)->substr(0, 1)->upper() }}
                </span>
                <span class="min-w-0">
                    <span class="block truncate text-sm font-medium text-slate-900">{{ auth()->user()->name }}</span>
                    <span class="block truncate text-xs text-slate-500">{{ auth()->user()->email }}</span>
                </span>
            </div>
        @else
            <p class="px-2 text-xs text-slate-500">{{ config('app.name') }}</p>
        @endauth
    </div>
</nav>
