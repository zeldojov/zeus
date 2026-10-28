@extends('layouts.app', ['title' => 'Login'])

@section('content')
    <x-auth-layout title="Prijavi se na svoj nalog">
        <form class="space-y-6" method="POST" action="{{ route('login') }}">
            @csrf

                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-slate-900">Email adresa</label>
                    <div class="mt-2">
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            required
                            autofocus
                            @class([
                                'block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6',
                                'ring-rose-300' => $errors->has('email'),
                                'ring-slate-300' => !$errors->has('email'),
                            ])
                        >
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between gap-3">
                        <label for="password" class="block text-sm font-medium leading-6 text-slate-900">Lozinka</label>
                        <a href="{{ route('password.request') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-600">Zaboravili ste lozinku?</a>
                    </div>
                    <div class="mt-2">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            @class([
                                'block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6',
                                'ring-rose-300' => $errors->has('password'),
                                'ring-slate-300' => !$errors->has('password'),
                            ])
                        >
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input
                        id="remember"
                        name="remember"
                        type="checkbox"
                        value="1"
                        @checked(old('remember'))
                        class="size-4 rounded border-slate-300 text-amber-600 focus:ring-amber-500"
                    >
                    <label for="remember" class="ml-3 block text-sm text-slate-700">Zapamti me</label>
                </div>

                <button type="submit" class="flex w-full justify-center rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold leading-6 text-white shadow-sm transition-colors hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                    Prijavi se
                </button>
        </form>

        <p class="mt-10 text-center text-sm text-slate-500">
            Nemate nalog?
            <a href="{{ route('register') }}" class="font-semibold leading-6 text-amber-700 hover:text-amber-600">Registrujte se</a>
        </p>
    </x-auth-layout>
@endsection
