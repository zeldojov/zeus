
@props([
    'href' => null,
    'fragment' => null,
    'form' => null,
    'base' => '',
    'normal' => 'text-text-muted',
    'active' => 'text-text-primary',
    'hover' => 'hover:text-text-secondary',
    'focus' => '',
])

@php
    $modes = array_filter([
        'href' => $href !== null,
        'fragment' => $fragment !== null,
        'form' => $form !== null,
    ]);

    if (count($modes) > 1) {
        throw new InvalidArgumentException(
            'Only one of href, fragment or form may be specified.'
        );
    }

    $isFragment = $fragment !== null;
    $isForm = $form !== null;

    $isActive = !$isFragment
        && !$isForm
        && $href !== null
        && parse_url(url($href), PHP_URL_PATH) === parse_url(request()->url(), PHP_URL_PATH);

    $url = $isFragment
        ? '#' . ltrim($fragment, '#')
        : ($isForm ? '#' : $href);
@endphp

<a
    @if ($url !== null)
        href="{{ $url }}"
    @endif

    @if ($isFragment)
        x-data="{
            fragment: window.location.hash,
            target: @js('#' . ltrim($fragment, '#')),
            get isActive() {
                return this.fragment === this.target;
            },
            init() {
                window.addEventListener('hashchange', () => {
                    this.fragment = window.location.hash;
                });
            }
        }"
        {{ $attributes->class([$base]) }}
        :class="{
            @js($normal): !isActive,
            @js($active): isActive,
            @js($hover): !isActive,
            @js($focus): true
        }"
        :aria-current="isActive ? 'location' : null"

    @elseif ($isForm)
        @click.prevent="document.getElementById(@js($form))?.requestSubmit()"
        {{ $attributes->class([$base, $normal, $hover, $focus]) }}

    @else
        {{ $attributes->class([
            $base,
            $isActive ? $active : $normal,
            $isActive ? '' : $hover,
            $focus,
        ]) }}
        @if ($isActive)
            aria-current="page"
        @endif
    @endif
>
    {{ $slot }}
</a>
