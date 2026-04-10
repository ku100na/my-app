<div
    {{ $attributes->merge([
            'class' => 'w-auto bg-base shadow-lg rounded-lg p-8 m-6'
        ]) }}>
    {{ $slot }}
</div>