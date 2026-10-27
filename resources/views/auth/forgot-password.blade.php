@extends('layouts.app', ['title' => 'Forgot Password'])

@section('content')
    <x-auth-layout title="Zaboravljena lozinka" description="Unesite email adresu i poslaćemo vam link za promenu lozinke.">
        <form class="space-y-6" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-slate-900">Email adresa</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="flex w-full justify-center rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold leading-6 text-white shadow-sm transition-colors hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                Pošalji link za resetovanje
            </button>
        </form>

        <p class="mt-10 text-center text-sm text-slate-500">
            <a href="{{ route('login') }}" class="font-semibold leading-6 text-amber-700 hover:text-amber-600">Nazad na prijavu</a>
        </p>
    </x-auth-layout>
@endsection
