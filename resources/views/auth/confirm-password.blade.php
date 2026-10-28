@extends('layouts.app', ['title' => 'Confirm Password'])

@section('content')
    <x-auth-layout title="Potvrdite lozinku" description="Unesite lozinku pre nego što nastavite.">
        <form class="space-y-6" method="POST" action="{{ route('password.confirm.store') }}">
            @csrf

            <div>
                <label for="password" class="block text-sm font-medium leading-6 text-slate-900">Lozinka</label>
                <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="current-password" required autofocus class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="flex w-full justify-center rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold leading-6 text-white shadow-sm transition-colors hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                Potvrdi lozinku
            </button>
        </form>
    </x-auth-layout>
@endsection
