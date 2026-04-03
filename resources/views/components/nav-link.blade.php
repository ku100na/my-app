@props(['active', 
    'href' => null,
    'type' => 'button'
    ])

@if($active)
    <x-primary-button :href="$href" {{ $attributes }}>
        {{ $slot }}
    </x-primary-button>

@else
    <x-white-button :type="$type" {{ $attributes }}>
        {{ $slot }}
    </x-white-button>
@endif