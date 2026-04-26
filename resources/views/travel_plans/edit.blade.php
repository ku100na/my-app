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

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-plan-deletion')"
        class="mt-8"
    >プラン削除</x-danger-button>

    <x-modal name="confirm-plan-deletion" focusable>
        <form method="post" action="{{ route('travel-plans.destroy', $travelPlan) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                このプランを削除しますか？
            </h2>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    キャンセル
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    削除
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>