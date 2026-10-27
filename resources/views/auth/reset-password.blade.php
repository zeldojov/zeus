@extends('layouts.app', ['title' => 'Reset Password'])

@section('content')
    <x-auth-layout title="Postavite novu lozinku" description="Izaberite novu lozinku za svoj nalog.">
        <form class="space-y-6" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-slate-900">Email adresa</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" value="{{ old('email', request('email')) }}" autocomplete="email" required autofocus class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium leading-6 text-slate-900">Nova lozinka</label>
                <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="new-password" required class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium leading-6 text-slate-900">Potvrdi novu lozinku</label>
                <div class="mt-2">
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
                </div>
            </div>

            <button type="submit" class="flex w-full justify-center rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold leading-6 text-white shadow-sm transition-colors hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                Promeni lozinku
            </button>
        </form>
    </x-auth-layout>
@endsection
