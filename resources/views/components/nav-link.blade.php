@props(['href'])

@php
$current = request()->routeIs('travel_plans.index');
@endphp


@if($current)
    <x-blue-button :href="$href" {{ $attributes }}>
        {{ $slot }}
    </x-blue-button>

@else
    <x-white-button :type="$type" {{ $attributes }}>
        {{ $slot }}
    </x-white-button>
@endif