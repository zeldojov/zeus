@extends('layouts.app', ['title' => 'Account Settings'])

@section('sidebar-context')
    <x-navbar-link secondary url="{{ url('/user/settings') . '#personal-information' }}" fragment="personal-information" text="Lični podaci" />
    <x-navbar-link secondary url="{{ url('/user/settings') . '#password' }}" fragment="password" text="Lozinka" />
    <x-navbar-link secondary url="{{ url('/user/settings') . '#two-factor' }}" fragment="two-factor" text="Dvofaktorska zaštita" />
    <x-navbar-link secondary url="{{ url('/user/settings') . '#sessions' }}" fragment="sessions" text="Sesije" />
@endsection

@section('content')
    <div class="mx-auto max-w-7xl">
        <header class="border-b border-slate-200">
            <div class="py-6">
                <p class="text-sm font-medium text-amber-700">Nalog</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-950">Podešavanja naloga</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">Upravljajte ličnim podacima i bezbednošću naloga.</p>
            </div>
        </header>

        <div class="divide-y divide-slate-200">
            <section id="personal-information" class="scroll-mt-20 grid grid-cols-1 gap-x-8 gap-y-8 py-10 md:grid-cols-3 lg:py-12">
                <div>
                    <h3 class="text-base font-semibold leading-7 text-slate-950">Lični podaci</h3>
                    <p class="mt-1 text-sm leading-6 text-slate-600">Ažurirajte ime, korisničko ime i email adresu povezanu sa nalogom.</p>
                    <p class="mt-4 text-sm text-slate-600">
                        Email je
                        @if (auth()->user()->hasVerifiedEmail())
                            <span class="font-medium text-emerald-700">potvrđen</span>.
                        @else
                            <span class="font-medium text-amber-700">nepotvrđen</span>.
                        @endif
                    </p>
                </div>

                <form method="POST" action="{{ route('user-profile-information.update') }}" class="space-y-6 md:col-span-2">
                    @csrf
                    @method('PUT')

                    @if (session('status') === 'profile-information-updated')
                        <p class="rounded-md bg-emerald-50 px-3 py-2 text-sm text-emerald-800" role="status">
                            Lični podaci su sačuvani.
                        </p>
                    @endif

                    <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="name" class="block text-sm font-medium leading-6 text-slate-900">Ime i prezime</label>
                            <div class="mt-2">
                                <input id="name" name="name" type="text" autocomplete="name" required value="{{ old('name', auth()->user()->name) }}" class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
                            </div>
                            @error('name', 'updateProfileInformation')
                                <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="username" class="block text-sm font-medium leading-6 text-slate-900">Korisničko ime</label>
                            <div class="mt-2">
                                <input id="username" name="username" type="text" autocomplete="username" required value="{{ old('username', auth()->user()->username) }}" class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
                            </div>
                            @error('username', 'updateProfileInformation')
                                <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-6">
                            <label for="email" class="block text-sm font-medium leading-6 text-slate-900">Email adresa</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email', auth()->user()->email) }}" class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
                            </div>
                            @error('email', 'updateProfileInformation')
                                <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end border-t border-slate-200 pt-5">
                        <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                            Sačuvaj izmene
                        </button>
                    </div>
                </form>
            </section>

            <section id="password" class="scroll-mt-20 grid grid-cols-1 gap-x-8 gap-y-8 py-10 md:grid-cols-3 lg:py-12">
                <div>
                    <h3 class="text-base font-semibold leading-7 text-slate-950">Promena lozinke</h3>
                    <p class="mt-1 text-sm leading-6 text-slate-600">Koristite jedinstvenu lozinku koju ne koristite na drugim mestima.</p>
                </div>

                <form method="POST" action="{{ route('user-password.update') }}" class="space-y-6 md:col-span-2">
                    @csrf
                    @method('PUT')

                    @if (session('status') === 'password-updated')
                        <p class="rounded-md bg-emerald-50 px-3 py-2 text-sm text-emerald-800" role="status">
                            Lozinka je promenjena.
                        </p>
                    @endif

                    <div>
                        <label for="current_password" class="block text-sm font-medium leading-6 text-slate-900">Trenutna lozinka</label>
                        <div class="mt-2">
                            <input id="current_password" name="current_password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
                        </div>
                        @error('current_password', 'updatePassword')
                            <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                        <div>
                            <label for="password" class="block text-sm font-medium leading-6 text-slate-900">Nova lozinka</label>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" autocomplete="new-password" required class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
                            </div>
                            @error('password', 'updatePassword')
                                <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium leading-6 text-slate-900">Potvrdi novu lozinku</label>
                            <div class="mt-2">
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end border-t border-slate-200 pt-5">
                        <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                            Promeni lozinku
                        </button>
                    </div>
                </form>
            </section>

            <section
                id="two-factor"
                class="scroll-mt-20 grid grid-cols-1 gap-x-8 gap-y-8 py-10 md:grid-cols-3 lg:py-12"
                x-init="
                    if (sessionStorage.getItem('settings-scroll-target') === 'two-factor') {
                        sessionStorage.removeItem('settings-scroll-target');
                        window.location.hash = 'two-factor';
                    }
                "
            >
                <div>
                    <h3 class="text-base font-semibold leading-7 text-slate-950">Dvofaktorska zaštita</h3>
                    <p class="mt-1 text-sm leading-6 text-slate-600">Koristite aplikaciju za autentifikaciju kao dodatni korak pri prijavi.</p>
                    @if (auth()->user()->hasEnabledTwoFactorAuthentication())
                        <p class="mt-4 text-sm text-slate-600">
                            Dvofaktorska zaštita je <span class="font-medium text-emerald-700">uključena</span>.
                        </p>
                    @endif
                </div>

                <div class="space-y-6 md:col-span-2">
                    @if (session('status') === 'two-factor-authentication-enabled')
                        <p class="rounded-md bg-amber-50 px-3 py-2 text-sm text-amber-800" role="status">
                            Skenirajte QR kod, pa unesite generisani kod da biste završili podešavanje.
                        </p>
                    @elseif (session('status') === 'two-factor-authentication-disabled')
                        <p class="rounded-md bg-slate-100 px-3 py-2 text-sm text-slate-700" role="status">
                            Dvofaktorska zaštita je isključena.
                        </p>
                    @elseif (session('status') === 'recovery-codes-generated')
                        <p class="rounded-md bg-emerald-50 px-3 py-2 text-sm text-emerald-800" role="status">
                            Novi recovery kodovi su generisani. Sačuvajte ih sada.
                        </p>
                    @endif

                    @if (auth()->user()->two_factor_secret)
                        <div class="grid grid-cols-1 gap-6 rounded-lg border border-slate-200 bg-white p-5 sm:grid-cols-[12rem_minmax(0,1fr)]">
                            <img
                                src="data:image/svg+xml;base64,{{ base64_encode(auth()->user()->twoFactorQrCodeSvg()) }}"
                                alt="QR kod za dvofaktorsku zaštitu"
                                class="size-48 rounded border border-slate-200 bg-white p-2"
                            >
                            <div class="min-w-0">
                                <h4 class="text-sm font-semibold text-slate-900">Dodavanje uređaja</h4>
                                <p class="mt-1 text-sm leading-6 text-slate-600">Skenirajte QR kod drugim uređajem ili unesite tajni ključ ručno u aplikaciju za autentifikaciju.</p>
                                <p class="mt-4 text-sm font-medium text-slate-900">Tajni ključ za ručni unos</p>
                                <p class="mt-2 break-all rounded-md bg-slate-50 px-3 py-2 font-mono text-sm text-slate-800">{{ \Laravel\Fortify\Fortify::currentEncrypter()->decrypt(auth()->user()->two_factor_secret) }}</p>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->hasEnabledTwoFactorAuthentication())
                        <div class="rounded-lg border border-slate-200 bg-white p-4">
                            <h4 class="text-sm font-semibold text-slate-900">Recovery kodovi</h4>
                            <p class="mt-1 text-sm text-slate-600">Svaki kod može da se iskoristi samo jednom.</p>
                            <ul class="mt-4 grid grid-cols-1 gap-2 font-mono text-sm text-slate-800 sm:grid-cols-2">
                                @foreach (auth()->user()->recoveryCodes() as $recoveryCode)
                                    <li class="rounded bg-slate-50 px-3 py-2">{{ $recoveryCode }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <form method="POST" action="{{ route('two-factor.recovery-codes') }}" x-on:submit="sessionStorage.setItem('settings-scroll-target', 'two-factor')">
                            @csrf
                            <button type="submit" class="text-sm font-semibold text-amber-700 hover:text-amber-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                                Generiši nove recovery kodove
                            </button>
                        </form>

                        <div class="flex justify-end border-t border-slate-200 pt-5">
                            <form method="POST" action="{{ route('two-factor.disable') }}" x-on:submit="sessionStorage.setItem('settings-scroll-target', 'two-factor')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-md border border-rose-300 bg-white px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-500">
                                    Isključi 2FA
                                </button>
                            </form>
                        </div>
                    @elseif (auth()->user()->two_factor_secret)
                        <div class="rounded-lg border border-slate-200 bg-white p-5">
                            <h4 class="text-sm font-semibold text-slate-900">Potvrdite podešavanje</h4>
                            <p class="mt-1 text-sm text-slate-600">Unesite kod iz aplikacije za autentifikaciju da biste uključili dvofaktorsku zaštitu.</p>

                            <form method="POST" action="{{ route('two-factor.confirm') }}" x-on:submit="sessionStorage.setItem('settings-scroll-target', 'two-factor')" class="mt-6 max-w-sm space-y-4">
                                @csrf
                                <div>
                                    <label for="two_factor_code" class="block text-sm font-medium text-slate-900">Šestocifreni kod</label>
                                    <input id="two_factor_code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code" required autofocus class="mt-2 block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm">
                                    @error('code')
                                        <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                                    Potvrdi i uključi 2FA
                                </button>
                            </form>

                            <form method="POST" action="{{ route('two-factor.disable') }}" x-on:submit="sessionStorage.setItem('settings-scroll-target', 'two-factor')" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-slate-600 underline decoration-slate-300 underline-offset-4 hover:text-slate-900">
                                    Otkaži podešavanje
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex flex-col gap-4 rounded-lg border border-slate-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Dvofaktorska zaštita je isključena</p>
                                <p class="mt-1 text-sm text-slate-600">Dodajte dodatni sloj zaštite nalogu pomoću jednokratnog koda.</p>
                            </div>
                            <form method="POST" action="{{ route('two-factor.enable') }}">
                                @csrf
                                <button type="submit" class="shrink-0 rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                                    Uključi 2FA
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </section>

            <section id="sessions" class="scroll-mt-20 grid grid-cols-1 gap-x-8 gap-y-8 py-10 md:grid-cols-3 lg:py-12">
                <div>
                    <h3 class="text-base font-semibold leading-7 text-slate-950">Prijavljene sesije</h3>
                    <p class="mt-1 text-sm leading-6 text-slate-600">Pregledajte uređaje na kojima je vaš nalog prijavljen i uklonite sesije koje više ne koristite.</p>
                </div>

                <div class="space-y-4 md:col-span-2">
                    @if (session('status') === 'session-removed')
                        <p class="rounded-md bg-emerald-50 px-3 py-2 text-sm text-emerald-800" role="status">
                            Sesija je uklonjena.
                        </p>
                    @elseif (session('status') === 'other-sessions-removed')
                        <p class="rounded-md bg-emerald-50 px-3 py-2 text-sm text-emerald-800" role="status">
                            Sve ostale sesije su uklonjene.
                        </p>
                    @endif

                    @if (! $sessionManagementAvailable)
                        <p class="rounded-md bg-slate-100 px-3 py-2 text-sm text-slate-700">
                            Pregled sesija zahteva database session driver.
                        </p>
                    @elseif ($sessions->isEmpty())
                        <p class="rounded-md bg-slate-100 px-3 py-2 text-sm text-slate-700">
                            Nema aktivnih sesija za prikaz.
                        </p>
                    @else
                        <ul class="divide-y divide-slate-200 rounded-lg border border-slate-200 bg-white">
                            @foreach ($sessions as $session)
                                <li class="flex flex-col gap-4 p-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="min-w-0 space-y-2">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="text-sm font-semibold text-slate-900">
                                                {{ $session->ip_address ?: 'Nepoznata IP adresa' }}
                                            </p>
                                            @if ($session->is_current)
                                                <span class="rounded bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-800">Trenutna sesija</span>
                                            @endif
                                        </div>
                                        <p class="wrap-break-word text-sm leading-6 text-slate-600">{{ $session->user_agent ?: 'Nepoznat uređaj ili pregledač' }}</p>
                                        <p class="text-xs text-slate-500">
                                            Poslednja aktivnost: {{ \Illuminate\Support\Carbon::createFromTimestamp((int) $session->last_activity)->timezone(config('app.timezone'))->format('d.m.Y. H:i') }}
                                        </p>
                                    </div>

                                    <form method="POST" action="{{ route('user.sessions.destroy') }}" class="shrink-0">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="session_id" value="{{ $session->id }}">
                                        <button type="submit" class="rounded-md border border-rose-300 bg-white px-3 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-500">
                                            {{ $session->is_current ? 'Odjavi ovu sesiju' : 'Ukloni sesiju' }}
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>

                        @if ($sessions->contains(fn ($session) => ! $session->is_current))
                            <div class="flex justify-end border-t border-slate-200 pt-5">
                                <form method="POST" action="{{ route('user.sessions.destroy-others') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                                        Ukloni sve ostale sesije
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
