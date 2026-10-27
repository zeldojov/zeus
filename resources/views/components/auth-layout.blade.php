@props([
    'title',
    'description' => null,
])

<div class="flex min-h-[calc(100vh-8rem)] flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <a href="{{ url('/') }}" class="mx-auto flex w-fit items-center gap-3 rounded-sm focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-amber-500">
            <span class="grid size-10 place-items-center rounded-lg bg-amber-400 text-slate-950" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" class="size-5" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 7h14M5 12h9M5 17h14" />
                </svg>
            </span>
            <span class="text-base font-semibold text-slate-900">{{ config('app.name') }}</span>
        </a>
        <h1 class="mt-10 text-center text-2xl font-bold leading-9 text-slate-900">{{ $title }}</h1>
        @if ($description)
            <p class="mt-2 text-center text-sm leading-6 text-slate-600">{{ $description }}</p>
        @endif
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        @if (session('status'))
            <p class="mb-6 rounded-md bg-emerald-50 px-3 py-2 text-sm text-emerald-800" role="status">
                {{ session('status') }}
            </p>
        @endif

        {{ $slot }}
    </div>
</div>
