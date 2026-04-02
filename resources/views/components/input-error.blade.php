@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>

            @if ($message === __('passwords.token')) 
                <a href="{{ route('password.request') }}" class="underline text-primary01 hover:text-indigo-500">
                    もう一度リクエストする
                </a> 
            @endif 
        @endforeach
    </ul>
@endif
