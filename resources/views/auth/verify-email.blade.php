@extends('layouts.app', ['title' => 'Verify Email'])

@section('content')
    <x-auth-layout title="Potvrdite email adresu" description="Pre nastavka proverite email i otvorite link za potvrdu koji smo vam poslali.">
        <div class="space-y-6">
            @if ($errors->any())
                <p class="rounded-md bg-rose-50 px-3 py-2 text-sm text-rose-700" role="alert">
                    {{ $errors->first() }}
                </p>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="flex w-full justify-center rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold leading-6 text-white shadow-sm transition-colors hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                    Pošalji novi link za potvrdu
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-sm font-semibold leading-6 text-amber-700 hover:text-amber-600">
                    Odjavi se
                </button>
            </form>
        </div>
    </x-auth-layout>
@endsection
