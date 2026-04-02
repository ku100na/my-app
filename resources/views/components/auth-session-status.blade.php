@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}

        @if ($status === __('passwords.token'))
            <br>
            <a href="{{ route('password.request') }}" class="underline text-blue-600">もう一度リクエストする
            </a>
        @endif
    </div>
@endif
