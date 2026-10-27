@extends('layouts.app', ['title' => 'Two-Factor Challenge'])

@section('content')
	<x-auth-layout title="Potvrdite prijavu" description="Unesite kod iz aplikacije za autentifikaciju.">
		<form class="space-y-6" method="POST" action="{{ route('two-factor.login.store') }}" x-data="{ useRecoveryCode: @js($errors->has('recovery_code')) }">
			@csrf

			<div x-cloak x-show="!useRecoveryCode">
				<label for="code" class="block text-sm font-medium leading-6 text-slate-900">Autentifikacioni kod</label>
				<div class="mt-2">
					<input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code" x-bind:required="!useRecoveryCode" x-bind:disabled="useRecoveryCode" autofocus class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
				</div>
				@error('code')
					<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
				@enderror
			</div>

			<div x-cloak x-show="useRecoveryCode">
				<label for="recovery_code" class="block text-sm font-medium leading-6 text-slate-900">Kod za oporavak</label>
				<div class="mt-2">
					<input id="recovery_code" name="recovery_code" type="text" autocomplete="one-time-code" x-bind:required="useRecoveryCode" x-bind:disabled="!useRecoveryCode" class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm sm:leading-6">
				</div>
				@error('recovery_code')
					<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
				@enderror
			</div>

			<button type="submit" class="flex w-full justify-center rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold leading-6 text-white shadow-sm transition-colors hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
				Nastavi
			</button>

			<button type="button" class="w-full text-center text-sm font-semibold text-amber-700 hover:text-amber-600" x-on:click="useRecoveryCode = !useRecoveryCode">
				<span x-show="!useRecoveryCode">Koristi kod za oporavak</span>
				<span x-cloak x-show="useRecoveryCode">Koristi autentifikacioni kod</span>
			</button>
		</form>
	</x-auth-layout>
@endsection
