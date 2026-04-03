@props([
    'href' => null,
    'type' => 'button',
])

@if ($href)
    <a href="{{ $href }}"
       {{ $attributes->merge([
            'class' => 'inline-flex items-center px-4 py-2 bg-primary02 border border-transparent rounded-md font-semibold text-xs text-cream tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 ring-offset-cream transition ease-in-out duration-150'
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
        {{ $attributes->merge([
            'class' => 'inline-flex items-center px-4 py-2 bg-primary02 border border-transparent rounded-md font-semibold text-xs text-cream tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 ring-offset-cream transition ease-in-out duration-150'
        ]) }}>
        {{ $slot }}
    </button>
@endif