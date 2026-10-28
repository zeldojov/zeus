@props([
    'url' => '',
    'fragment' => '',
    'text' => 'Welcome',
    'logout' => false,

    'base' => 'block font-bold text-xs uppercase tracking-tight',
    'normal' => 'text-zinc-500 hover:text-zinc-400',
    'active' => 'text-zinc-50',
])

@php
    $base_url = explode('#', $url)[0];
    $is_active = request()->url() === $base_url;
@endphp

@if ($logout)
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" @class([
            $base => true,
            $active => $is_active,
            $normal => !$is_active,
        ])>
            {{ $text }}
        </button>
    </form>
@elseif($fragment)
    @php
        $fragment = '#' . $fragment;
    @endphp
    <a x-data="{
        currentFragment: window.location.hash,

        init() {
            window.addEventListener('hashchange', () => {
                this.currentFragment = window.location.hash;
            });
        }
    }" href="{{ $url }}" @class([$base])
        :class="{
            'text-red-50': {{ Illuminate\Support\Js::from($fragment !== '') }} && currentFragment ===
                {{ Illuminate\Support\Js::from($fragment) }},
            'text-zinc-500': {{ Illuminate\Support\Js::from($fragment === '') }} || currentFragment !==
                {{ Illuminate\Support\Js::from($fragment) }}
        }">
        {{ $text }}
    </a>
@else
    <a href="{{ $url }}" @class([
        $base => true,
        $active => $is_active,
        $normal => !$is_active,
    ])>
        {{ $text }}
    </a>
@endif
