@props([
    'href' => null,
    'type' => 'button',
])

@if ($href)
    <a href="{{ $href }}"
       {{ $attributes->merge([
           'class' => 'inline-flex items-center px-4 py-2 bg-transparent border-2 border-primary02 rounded-md font-semibold text-xs text-primary02 tracking-widest hover:bg-indigo-500 hover:text-cream hover:border-indigo-500 focus:bg-indigo-500 active:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:text-cream focus:border-transparent ring-offset-cream transition ease-in-out duration-150'
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
        {{ $attributes->merge([
            'class' => 'inline-flex items-center px-4 py-2 bg-transparent border-2 border-primary02 rounded-md font-semibold text-xs text-primary02 tracking-widest hover:bg-indigo-500 hover:text-cream hover:border-indigo-500 focus:bg-indigo-500 active:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:text-cream focus:border-transparent ring-offset-cream transition ease-in-out duration-150'
        ]) }}>
        {{ $slot }}
    </button>
@endif