<x-app-layout>
    <x-slot name="title">
        プラン作成
    </x-slot>

    <form method="POST" action="{{ route('travel-plans.store') }}" enctype="multipart/form-data" novalidate>
        @csrf
        @include('travel_plans._form')
        <x-primary-button type="submit" class="mt-4">作成</x-primary-button>
    </form>
</x-app-layout>