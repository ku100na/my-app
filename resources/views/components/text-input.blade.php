@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-primary03 border-4 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
