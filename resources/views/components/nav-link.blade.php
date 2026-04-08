@props([
    'href',
    'activeRoute' => null,
])

@php
$current = $activeRoute ? request()->routeIs($activeRoute) : false;
@endphp


@if($current)
    <x-blue-button :href="$href" {{ $attributes }}>
        {{ $slot }}
    </x-blue-button>

@else
    <x-white-button :href="$href" {{ $attributes }}>
        {{ $slot }}
    </x-white-button>
@endif