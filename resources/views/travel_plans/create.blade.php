<x-app-layout>
    <x-slot name="title">
        プラン作成
    </x-slot>

    <form method="POST" action="{{ route('travel_plans.store') }}">
        @csrf
        @include('travel_plans._form')
        <x-primary-button type="submit">作成</x-primary-button>
    </form>
</x-app-layout>