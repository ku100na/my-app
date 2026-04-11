<x-app-layout>
    <x-slot name="title">
        プラン編集
    </x-slot>

    <form method="POST" action="{{ route('travel-plans.update', $travelPlan) }}" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        @include('travel_plans._form')
        <x-primary-button type="submit" class="mt-4">編集</x-primary-button>
    </form>
</x-app-layout>