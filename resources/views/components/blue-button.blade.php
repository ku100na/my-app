@props([
    'href' => null,
    'type' => 'button',
])

@if ($href)
    <a href="{{ $href }}"
       {{ $attributes->merge([
           'class' => 'inline-flex items-center px-4 py-2 bg-indigo-500 ring-2 ring-indigo-500 rounded-md font-semibold text-xs text-cream tracking-widest ring-offset-2 ring-offset-cream'
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
        {{ $attributes->merge([
           'class' => 'inline-flex items-center px-4 py-2 bg-indigo-500 ring-2 ring-indigo-500 rounded-md font-semibold text-xs text-cream tracking-widest ring-offset-2 ring-offset-cream'
        ]) }}>
        {{ $slot }}
    </button>
@endif