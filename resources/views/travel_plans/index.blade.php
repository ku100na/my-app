<x-app-layout>
    <x-slot name="title">
        <div class="flex justify-between">
            <div>プラン一覧</div>
            <div class="font-normal">検索</div>
        </div>
    </x-slot>

    @auth
    <div class="flex justify-center">
        <a href="{{ route('travel_plans.index',['type' => 'mine']) }}">
            @if(request('type') === 'mine')
                <x-blue-button>自分のプラン</x-blue-button>
            @else
                <x-white-button>自分のプラン</x-white-button>
            @endif
        </a>
        <a href="{{ route('travel_plans.index',['type' => 'all']) }}" class="ml-4">
            @if(request('type') === 'mine')
                <x-white-button>みんなのプラン</x-white-button>
            @else
                <x-blue-button>みんなのプラン</x-blue-button>
            @endif
        </a>
    </div>
    @endauth

    <div class="p-6 flex flex-col">
        <div class="hidden sm:block">
            <table class="mx-auto bg-base border border-primary03 p-8">
                <thead class="bg-primary03">
                    <tr>
                        <th class="px-4 py-2">プラン名</th>
                        <th class="px-4 py-2">旅行先</th>
                        <th class="px-4 py-2">期間</th>
                        <th class="px-4 py-2">ステータス</th>
                        <th class="px-4 py-2"></th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $plan)
                    <tr>
                        <td class="px-4 py-2">{{ $plan->title }}</td>
                        <td class="px-4 py-2">{{ $plan->city }}</td>
                        <td class="px-4 py-2">{{ $plan->start_date }} ~ {{ $plan->end_date }}</td>
                        <td class="px-4 py-2">
                            @if($plan->status === 'planned')
                                予定
                            @elseif($plan->status === 'completed')
                                完了
                            @endif
                        </td>
                        <td class="px-4 py-2"><x-primary-button>詳細</x-primary-button></td>
                        <td class="px-4 py-2"><x-primary-button>編集</x-primary-button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="sm:hidden space-y-4">
            @foreach($plans as $plan)
                <div class="bg-base shadow-lg rounded-lg overflow-hidden">
                    <div class="bg-primary03 font-bold w-full p-2">
                        {{ $plan->title }}
                    </div>
                    
                    <div class="p-4 text-gray-800">
                        <div>{{ $plan->city }}</div>
                        <div>{{ $plan->start_date }} ~ {{ $plan->end_date }}</div>
                        <div>
                            @if($plan->status === 'planned')
                                予定
                            @else
                                完了
                            @endif
                        </div>
                    </div>
                    <div class="flex space-x-2 ml-4 mb-4">
                        <x-primary-button>詳細</x-primary-button>
                        <x-primary-button>編集</x-primary-button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $plans->appends(request()->query())->links()}}
        </div>

        @auth
        <div class="mt-8">
            <x-primary-button href="{{ route('travel_plans.create') }}">
                ＋作成
            </x-primary-button>
        </div>
        @endauth
    </div>
</x-app-layout>